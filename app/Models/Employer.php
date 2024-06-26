<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'allow_posting',
    ];

    //relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
