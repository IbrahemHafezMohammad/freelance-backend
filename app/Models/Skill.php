<?php

namespace App\Models;

use App\Constants\PostSkillConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'active_projects_count',
    ];

    //relationship
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function jobPosts(): BelongsToMany
    {
        return $this->belongsToMany(JobPost::class, PostSkillConstants::TABLE_NAME);
    }
}
