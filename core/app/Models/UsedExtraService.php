<?php

namespace App\Models;

use App\Traits\CurrentOwner;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class UsedExtraService extends Model
{
    use Searchable, CurrentOwner;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function extraService()
    {
        return $this->belongsTo(ExtraService::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bookedRoom()
    {
        return $this->belongsTo(Room::class);
    }

    public function actionBy()
    {
        return $this->belongsTo(Owner::class, 'action_by');
    }
}
