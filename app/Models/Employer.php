<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_active',
        'is_2fa_enabled',
        'google2fa_secret',
        'allow_posting',
    ];
}
