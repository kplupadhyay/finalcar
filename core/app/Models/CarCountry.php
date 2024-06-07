<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class CarCountry extends Model
{
    // use HasFactory;
    protected $primaryKey = 'id';
    use GlobalStatus;

    public function cities(){
        return $this->hasMany(CarCity::class, 'country_id');
    }
}
