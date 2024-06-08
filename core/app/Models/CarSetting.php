<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CarSetting extends Model
// {
//     use HasFactory;
// }


// <?php

namespace App\Models;

use App\Traits\CurrentOwner;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CarSetting extends Model
{
    use CurrentOwner;

    protected $casts = [
        'keywords' => 'array'
    ];

    protected $appends = ['image_url'];

    public function owner(){
        return $this->belongsTo(CarOw::class ,"owner_id");
    }

    public function country(){
        return $this->belongsTo(CarCountry::class);
    }

    public function city(){
        return $this->belongsTo(CarCity::class);
    }

    public function location(){
        return $this->belongsTo(CarLocation::class);
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
