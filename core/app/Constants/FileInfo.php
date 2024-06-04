<?php

namespace App\Constants;

class FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This class basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo()
    {
        $data['gateway'] = [
            'path'       => 'assets/images/gateway',
            'size'       => '800x800',
        ];
        $data['withdrawVerify'] = [
            'path' => 'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      => 'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      => 'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/default.png',
        ];
        $data['withdrawMethod'] = [
            'path'      => 'assets/images/withdraw/method',
            'size'      => '800x800',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['language'] = [
            'path'      => 'assets/images/lang',
            'size'      => '64x64',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/logoIcon',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/extensions',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['userProfile'] = [
            'path'      => 'assets/images/user/profile',
            'size'      => '350x300',
        ];
        $data['ownerProfile'] = [
            'path'      => 'assets/owner/images/profile',
            'size'      => '400x400',
        ];
        $data['roomTypeImage'] = [
            'path'      => 'assets/images/roomType',
            'size'      => '427x250',
        ];

        $data['maintenance'] = [
            'path'      => 'assets/images/maintenance',
            'size'      => '700x400',
        ];

        $data['hotelImage'] = [
            'path'      => 'assets/images/hotel/image',
            'size'      => '340x200'
            
        ];        
        $data['coverPhoto'] = [
            'path'      => 'assets/images/hotel/cover',
            'size'      => '600x600'
        ];
        $data['ads'] = [
            'path'      => 'assets/images/ads',
            'size'      => '480x270',
        ];
        $data['city'] = [
            'path'      => 'assets/images/city',
            'size'      => '300x400',
        ];
        $data['facility'] = [
            'path'      => 'assets/images/facilities',
            'size'      => '40x40',
        ];
        $data['amenity'] = [
            'path'      => 'assets/images/amenities',
            'size'      => '40x40',
        ];
        $data['adminProfile'] = [
            'path'      =>'assets/admin/images/profile',
            'size'      =>'400x400',
        ];
        return $data;
    }
}
