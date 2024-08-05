<?php

namespace App\Models;

use App\Constants\UserConstants;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
        'is_active',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private static $withoutAppends = [];

    protected $appends = ['gender_name'];

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

    public function getGenderNameAttribute()
    {
        return UserConstants::getGender($this->gender);
    }

    protected function password(): Attribute
    {
        return new Attribute(
            set: fn ($value) => Hash::make($value)
        );
    }

    // overwrite
    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new VerifyEmail);
    // }
    
    // relations

    public function seeker(): HasOne
    {
        return $this->hasOne(Seeker::class);
    }

    public function employer(): HasOne
    {
        return $this->hasOne(Employer::class);
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
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

    //custom functions
    public static function checkSeekerUserName($user_name)
    {
        $user = self::firstWhere('user_name', $user_name);

        return (!$user || !$user->seeker) ? null : $user;
    }

    public static function checkAdminUserName($user_name)
    {
        $user = self::firstWhere('user_name', $user_name);

        return (!$user || !$user->admin) ? null : $user;
    }

    public static function checkEmployerUserName($user_name)
    {
        $user = self::firstWhere('user_name', $user_name);

        return (!$user || !$user->employer) ? null : $user;
    }

    public function verifyPassword($password)
    {
        return Hash::check($password, $this->password);
    }
}
