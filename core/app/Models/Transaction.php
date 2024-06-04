<?php

namespace App\Models;

use App\Traits\ApiQuery;
use App\Traits\CurrentOwner;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Searchable, CurrentOwner, ApiQuery;

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
