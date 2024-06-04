<?php

namespace App\Models;

use App\Traits\CurrentOwner;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use GlobalStatus, Searchable, CurrentOwner;

    protected $fillable = ['id'];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function booked()
    {
        return $this->hasMany(BookedRoom::class, 'room_id');
    }

    public function discountAmount(){
        $discount = $this->roomType->fare * $this->roomType->discount_percentage / 100;
        return $discount;
    }
}
