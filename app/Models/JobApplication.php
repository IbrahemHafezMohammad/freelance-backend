<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Constants\JobApplicationConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeker_id',
        'job_post_id',
        'resume',
        'message',
        'status'
    ];

    private static $withoutAppends = [];

    protected $appends = ['status_name'];

    protected function getArrayableAppends()
    {
        $this->appends = array_diff($this->appends, self::$withoutAppends);

        return parent::getArrayableAppends();
    }

    public function scopeWithoutAppendedAttributes($query, $appends = [])
    {
        self::$withoutAppends = empty($appends) ? $this->appends : $appends;

        return $query;
    }

    public function getStatusNameAttribute()
    {
        return JobApplicationConstants::getStatus($this->status);
    }

    //relationships
    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    // custom function 

    public static function getApplications($searchParams, $user)
    {
        $query = self::with([
            'jobPost' => function ($query) {
                $query->with(['skills', 'employer.user']);
            },
        ]);

        if ($user->seeker) {

            $query = $query->where('seeker_id', $user->seeker->id)
                ->whereHas('jobPost', function ($query) {
                    $query->where('is_active', true);
                });

        } elseif ($user->employer) {

            $query = $query->where('employer_id', $user->employer->id);
        }

        if (array_key_exists('user_name', $searchParams)) {

            $query->userName($searchParams['user_name']);
        }

        if (array_key_exists('title', $searchParams)) {

            $query->jobTitle($searchParams['title']);
        }

        if (array_key_exists('created_at', $searchParams)) {

            $query->createdAt($searchParams['created_at']);
        }

        if (array_key_exists('status', $searchParams)) {

            $query->status($searchParams['status']);
        }

        return $query;
    }

    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }

    public function scopeUserName($query, $user_name)
    {
        $query->whereHas('seeker', function ($query) use ($user_name) {
            $query->whereHas('user', function ($query) use ($user_name) {
                $query->where('user_name', 'LIKE', '%' . $user_name . '%');
            });
        })->orWhereHas('jobPost', function ($query) use ($user_name) {
            $query->whereHas('employer', function ($query) use ($user_name) {
                $query->whereHas('user', function ($query) use ($user_name) {
                    $query->where('user_name', 'LIKE', '%' . $user_name . '%');
                });
            });
        });
    }

    public function scopeCreatedAt($query, $created_at)
    {
        $query->where('created_at', '>=', $created_at);
    }

    public function scopeJobTitle($query, $title)
    {
        $query->WhereHas('jobPost', function ($query) use ($title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        });
    }
}
