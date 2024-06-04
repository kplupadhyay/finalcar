<?php

namespace App\Models;

use App\Traits\CurrentOwner;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class HotelSetting extends Model
{
    use CurrentOwner;

    protected $casts = [
        'keywords' => 'array'
    ];

    protected $appends = ['image_url'];

    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function () {
                return getImage(getFilePath('hotelImage') . '/' . $this->image);
            }
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            session()->forget('hotelSetting');
        });
    }
}
