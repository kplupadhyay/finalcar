<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\ApiQuery;
use App\Traits\OwnerNotify;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Owner extends Authenticatable
{
    use Searchable, OwnerNotify, ApiQuery;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'ver_code', 'balance'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'address'           => 'object',
        'ver_code_send_at'  => 'datetime',
        'form_data'         => 'object'
    ];

    public function loginLogs()
    {
        return $this->hasMany(OwnerLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class, 'owner_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hotelSetting()
    {
        return $this->hasOne(HotelSetting::class);
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function coverPhotos()
    {
        return $this->hasMany(CoverPhoto::class);
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

    public function featureBadge(): Attribute
    {
        return new Attribute(
            function () {
                $html = '';

                if ($this->is_featured == Status::YES) {
                    $html = '<span class="badge badge--success">' . trans('Featured') . '</span>';
                } else {
                    $html = '<span class="badge badge--dark">' . trans('Unfeatured') . '</span>';
                }

                return $html;
            }
        );
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            function () {
                $html = '';

                if ($this->status == Status::YES) {
                    $html = '<span class="badge badge--success">' . trans('Active') . '</span>';
                } else {
                    $html = '<span class="badge badge--dark">' . trans('Banned') . '</span>';
                }

                return $html;
            }
        );
    }

    //scope
    public function scopeOwner($query)
    {
        $query->where('parent_id', 0);
    }

    public function scopeOwnerRequest($query)
    {
        $query->owner()->where('status', Status::USER_REQUEST);
    }

    public function scopeActive($query)
    {
        $query->where('status', Status::USER_ACTIVE);
    }

    public function scopeNotExpired($query)
    {
        $query->whereDate('expire_at', '>=', now());
    }

    public function scopeBanned($query)
    {
        $query->where('status', Status::USER_BAN);
    }

    public function scopeFeatured($query)
    {
        $query->where('is_featured', Status::YES);
    }
}
