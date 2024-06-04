<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $appends = ['image_url'];

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function () {
                return getImage(getFilePath('ads') . '/' . $this->image, getFileSize('ads'));
            }
        );
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
