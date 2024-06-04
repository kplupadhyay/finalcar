<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class OwnerLogin extends Model
{
    use Searchable;

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
