<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'user_name',
        'birthday',
        'email',
        'password',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //custom functions
    public static function checkJobSeekerUserName($user_name)
    {
        $user = self::firstWhere('user_name', $user_name);

        return (!$user || !$user->jobSeeker) ? null : $user;
    }

    public static function checkEmployerUserName($user_name)
    {
        $user = self::firstWhere('user_name', $user_name);

        return (!$user || !$user->employer) ? null : $user;
    }

    // relations

    public function seeker(): HasOne
    {
        return $this->hasOne(Seeker::class);
    }

    public function employer(): HasOne
    {
        return $this->hasOne(Employer::class);
    }

    public function loginHistory(): HasMany
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function signupHistory()
    {
        return $this->hasOne(LoginHistory::class)->oldestOfMany();
    }

    public function latestLoginHistory()
    {
        return $this->hasOne(LoginHistory::class)->latestOfMany();
    }
}
