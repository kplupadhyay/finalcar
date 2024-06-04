<?php

namespace App\Models;

use App\Traits\CurrentOwner;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use Searchable, CurrentOwner;

    protected $guarded = ['id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function actionBy()
    {
        return $this->belongsTo(Owner::class, 'action_by');
    }
}
