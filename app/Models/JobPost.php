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
        'min_rate',
        'max_rate',
        'payment_type',
        'start_time',
        'end_time',
        'bid_start_time',
        'bid_end_time',
    ];

    private static $withoutAppends = [];

    protected $appends = ['status_name', 'payment_type_name'];

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

    public function getPaymentTypeNameAttribute()
    {
        return JobPostConstants::getPaymentType($this->payment_type);
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
}
