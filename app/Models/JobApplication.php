<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeker_id',
        'job_post_id',
        'resume',
        'message',
    ];

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
        if ($user->seeker) {

            $query = self::where('seeker_id', $user->seeker->id);
        } elseif ($user->employer) {

            $query = self::where('employer_id', $user->employer->id);
        } else {

            $query = self::query();
        }

        if (array_key_exists('user_name', $searchParams)) {

            $query->userName($searchParams['user_name']);
        }

        if (array_key_exists('title', $searchParams)) {

            $query->jobTitle($searchParams['title']);
        }

        if (array_key_exists('create_at', $searchParams)) {

            $query->createAt($searchParams['create_at']);
        }

        return $query;
    }

    public function scopeUserName($user_name, $query)
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

    public function scopeCreateAt($query, $created_at)
    {
        $query->where('created_at', '>=', $created_at);
    }
    
    public function scopeJobTitle($title, $query)
    {
        $query->WhereHas('jobPost', function ($query) use ($title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        });
    }
}
