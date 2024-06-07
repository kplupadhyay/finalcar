<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CarNotificationLog extends Model
// {
//     use HasFactory;
// }
// <?php

namespace App\Models;

use App\Traits\ApiQuery;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use Searchable, ApiQuery;
    
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function owner(){
    	return $this->belongsTo(Owner::class);
    }
}