<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Permission extends Model {

    public $timestamps = false;

    public $excludedActions = ['LoginController', 'ForgotPasswordController', 'ResetPasswordController', 'PermissionController', 'OwnerController@profile', 'OwnerController@profileUpdate', 'OwnerController@password', 'OwnerController@passwordUpdate'];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    protected static function boot() {
        parent::boot();
        static::saved(function () {
            Cache::forget('AllPermissions');
        });
    }
}
