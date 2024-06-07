<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CarUser extends Model
// {
//     use HasFactory;
// }

// <?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\UserNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class CarUser extends Authenticatable
{
    use HasApiTokens, Searchable, UserNotify, SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'ver_code', 'balance'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address'           => 'object',
        'ver_code_send_at'  => 'datetime'
    ];

    protected $dates = ['deleted_at'];


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function bookingRequest()
    {
        return $this->hasMany(CarBookingRequest::class)->where('status', Status::PAYMENT_INITIATE);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function booking()
    {
        return $this->hasMany(CarBooking::class);
    }

    public function bookingWithStatus($status)
    {
        return $this->hasMany(CarBooking::class)->where('status', $status);
    }

    public function bookedRoom()
    {
        return $this->hasManyThrough(BookedRoom::class, Booking::class);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->firstname . ' ' . $this->lastname;
            }
        );
    }

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED);
    }
    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }
    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::UNVERIFIED);
    }
    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }
    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }
    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }
}

