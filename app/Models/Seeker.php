<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seeker extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "is_active",
        "desc",
        "headline",
    ];

    //relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
