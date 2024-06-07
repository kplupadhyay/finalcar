<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CarCity extends Model
// {
//     use HasFactory;
// }



// <?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\ApiQuery;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CarCity extends Model
{
    use Searchable, ApiQuery;
    protected $appends = ['image_url'];

    public function country()
    {
        return $this->belongsTo(CarCountry::class);
    }

    public function locations()
    {
        return $this->hasMany(CarLocation::class , "city_id");
    }

    public function hotelSettings()
    {
        return $this->hasMany(CarSetting::class);
    }

    //scope
    public function scopeActive($query)
    {
        $query->whereHas('country', function ($country) {
            $country->where('status', Status::ENABLE);
        });
    }

    public function scopePopular($query)
    {
        $query->where('is_popular', Status::YES);
    }

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function () {
                return getImage(getFilePath('city') . '/' . $this->image);
            }
        );
    }

    public function popularBadge(): Attribute
    {
        return new Attribute(
            function () {
                $html = '';
                if ($this->is_popular == Status::YES) {
                    $html = '<span class="badge badge--primary">' . trans('Yes') . '</span>';
                } else {
                    $html = '<span><span class="badge badge--dark">' . trans('No') . '</span></span>';
                }
                return $html;
            }
        );
    }
}
