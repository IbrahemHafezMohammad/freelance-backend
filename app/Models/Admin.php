<?php

namespace App\Models;

use App\Constants\UserConstants;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FAQRCode\Google2FA;


class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_2fa_enabled',
        'google2fa_secret'
    ];

    protected $hidden = [
        'google2fa_secret'
    ];

    //accessors and mutators

    protected function google2faSecret(): Attribute
    {
        return new Attribute(
            get: fn($value) => !is_null($value) ? Crypt::decryptString($value) : null,
            set: fn($value) => !is_null($value) ? Crypt::encryptString($value) : null,
        );
    }

    //relations

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //custom function 
    public function scopeRole($query, $role)
    {
        $query->whereHas('user.roles', function (Builder $query) use ($role) {

            $query->where('roles.name', $role);
        });
    }

    public function scopeUserName($query, $user_name)
    {
        $query->whereHas('user', function (Builder $query) use ($user_name) {

            $query->where(UserConstants::TABLE_NAME . '.user_name', 'like', '%' . $user_name . '%');
        });
    }

    public static function getAdminsWithUserAndRoles($searchParams)
    {
        $query = Admin::with([
            'user' => function ($query) {
                $query->with(['signupHistory' , 'latestLoginHistory', 'roles:name'])->select(['id', 'name', 'user_name', 'phone']);
            },
        ]);

        if (array_key_exists('role', $searchParams)) {

            $query->role($searchParams['role']);
        }

        if (array_key_exists('user_name', $searchParams)) {

            $query->userName($searchParams['user_name']);
        }

        return $query;
    }

    //check 2FA
    public function verifyOTP(string $otp)
    {
        $google2fa = new Google2FA();

        if ($this->google2fa_secret) {
            return $google2fa->verifyKey($this->google2fa_secret, $otp, 1);
        }
        return false;
    }

    public function create2fA()
    {
        $google2fa = new Google2FA();

        $this->google2fa_secret = $google2fa->generateSecretKey();
        $this->save();

        return $google2fa->getQRCodeInline(
            config('app.name'),
            $this->user->user_name,
            $this->google2fa_secret
        );
    }
}
