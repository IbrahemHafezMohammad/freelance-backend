<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Constants\JobPostConstants;
use App\Constants\PostSkillConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    // scopes 

    public function scopeDesc($query, $desc)
    {
        $query->where('desc', 'LIKE', '%' . $desc . '%');
    }

    public function scopeTitle($query, $title)
    {
        $query->where('desc', 'LIKE', '%' . $title . '%');
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
