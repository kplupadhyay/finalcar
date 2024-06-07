<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CarFacilities extends Model
// {
//     use HasFactory;
// }
// <?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CarFacility extends Model
{
    use GlobalStatus;
    protected $appends = ['image_url'];

    public function roomTypes()
    {
        return $this->belongsToMany(CarType::class, 'room_type_facilities');
    }

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function () {
                return getImage(getFilePath('facility') . '/' . @$this->image, getFileSize('facility'));
            }
        );
    }
}
