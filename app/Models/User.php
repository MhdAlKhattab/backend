<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'email',
        'password',
        'contury_number',
        'phone_number',
        'permission'
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

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class,'user_id');
    }

    public function withdraws(): HasMany
    {
        return $this->hasMany(Withdraw::class,'user_id');
    }

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class,'user_id');
    }
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class,'user_id');
    }

    public function info(): HasOne
    {
        return $this->hasOne(Info::class);
    }

}
