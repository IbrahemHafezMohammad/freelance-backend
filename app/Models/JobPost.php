<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Constants\JobPostConstants;
use App\Constants\PostSkillConstants;
use App\Constants\SkillConstants;
use App\Constants\UserConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'desc',
        'employer_id',
        'title',
        'is_active',
        'status',
        'image',
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
        return JobPostConstants::getStatus($this->status);
    }

    protected function image(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::isUrl($value) ? $value : ($value ? Storage::url($value) : null)
        );
    }

    //relationships
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, PostSkillConstants::TABLE_NAME);
    }

    public function JobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    // custom functions

    public static function getPosts($searchParams, $user)
    {
        $query = self::where('employer_id', $user->employer->id);

        if (array_key_exists('desc', $searchParams)) {

            $query->desc($searchParams['desc']);
        }

        if (array_key_exists('title', $searchParams)) {

            $query->title($searchParams['title']);
        }

        if (array_key_exists('status', $searchParams)) {

            $query->status($searchParams['status']);
        }

        if (array_key_exists('create_at', $searchParams)) {

            $query->createAt($searchParams['create_at']);
        }

        return $query;
    }

    public static function listJobs($searchParams, $user)
    {
        $query = self::with([
            'skills',
            'employer.user' 
        ])
            ->where('is_active', true)
            ->status(JobPostConstants::STATUS_OPENED)
            ->whereHas('JobApplications', function ($query) use ($user) {
                $query->where('seeker_id', '!=', $user->seeker->id);
            });

        if (array_key_exists('title', $searchParams)) {

            $query->title($searchParams['title']);
        }

        if (array_key_exists('skills', $searchParams)) {

            $query->relatedSkills($searchParams['skills']);
        }

        if (array_key_exists('create_at', $searchParams)) {

            $query->createAt($searchParams['create_at']);
        }

        if (array_key_exists('employer', $searchParams)) {

            $query->relatedEmployer($searchParams['employer']);
        }
        return $query;
    }
    // scopes 

    public function scopeRelatedEmployer($query, $employer)
    {
        $query->whereHas('employer', function ($query) use ($employer) {
            $query->whereHas('user', function ($query) use ($employer) {
                $query->where(UserConstants::TABLE_NAME . '.user_name', 'LIKE', '%' . $employer . '%')
                    ->orWhere(UserConstants::TABLE_NAME . '.name', 'LIKE', '%' . $employer . '%');
            });
        });
    }

    public function scopeRelatedSkills($query, $skills)
    {
        $query->whereHas('skills', function ($query) use ($skills) {
            $query->whereIn(SkillConstants::TABLE_NAME . '.id', $skills);
        });
    }

    public function scopeDesc($query, $desc)
    {
        $query->where('desc', 'LIKE', '%' . $desc . '%');
    }

    public function scopeTitle($query, $title)
    {
        $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }

    public function scopeCreateAt($query, $created_at)
    {
        $query->where('created_at', '>=', $created_at);
    }
}
