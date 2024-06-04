<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use Searchable;
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeActive($query)
    {
        $query->whereHas('city', function ($city) {
            $city->whereHas('country', function ($country) {
                $country->where('status', Status::ENABLE);
            });
        });
    }
}
