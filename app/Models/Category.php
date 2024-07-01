<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'image'
    ];

    protected function image(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::isUrl($value) ? $value : ($value ? Storage::url($value) : null)
        );
    }
    
    //relationship
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
}
