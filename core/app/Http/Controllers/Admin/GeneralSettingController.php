<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Image;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $pageTitle = 'General Setting';
        $timezones = json_decode(file_get_contents(resource_path('views/admin/partials/timezone.json')));
        $currentTimezone = array_search(config('app.timezone'), $timezones);
        return view('admin.setting.general', compact('pageTitle', 'timezones', 'currentTimezone'));
    }

    public function update(Request $request)
    {
        $maxNumber          = $request->payment_before ?? 0;
        $appVideoValidation = 'nullable';
        $general            = gs();


        if ($general->app_video == null) {
            $appVideoValidation = 'required|mimes:mp4,mov,ogg,gt';
        }

        $request->validate([
            'site_name'             => 'required',
            'cur_text'              => 'required',
            'cur_sym'               => 'required',
            'base_color'            => ['nullable', 'regex:/^[a-f0-9]{6}$/i'],
            'timezone'              => 'required|integer',
            'max_star_rating'       => 'required|integer|gte:3',
            'popularity_count_from' => 'required|integer|gte:1',
            'bill_per_month'        => 'required|numeric|gte:0',
            'maximum_payment_month' => 'required|integer|gte:1',
            'payment_before'        => 'required|integer|gt:0|lt:29',
            'remind_before_days'    => 'required|array',
            'remind_before_days.*'  => 'integer|min:1|max:' . $maxNumber,
            'app_video'             => $appVideoValidation
        ]);

        $general->site_name                     = $request->site_name;
        $general->cur_text                      = $request->cur_text;
        $general->cur_sym                       = $request->cur_sym;
        $general->base_color                    = str_replace('#', '', $request->base_color);
        $general->max_star_rating               = $request->max_star_rating;
        $general->popularity_count_from         = $request->popularity_count_from;
        $general->bill_per_month                = $request->bill_per_month;
        $general->payment_before                = $request->payment_before;
        $general->remind_before_days            = $request->remind_before_days;
        $general->maximum_payment_month         = $request->maximum_payment_month;


        if ($request->hasFile('app_video')) {
            try {
                $old = $general->app_video ? 'assets/video/' . $general->app_video : null;
                $general->app_video = fileUploader($request->app_video, 'assets/video', null, $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the app video'];
                return back()->withNotify($notify);
            }
        }

        $general->save();

        $timezones = json_decode(file_get_contents(resource_path('views/admin/partials/timezone.json')));
        $timezone = @$timezones[$request->timezone] ?? 'UTC';

        $timezoneFile = config_path('timezone.php');
        $content = '<?php $timezone = "' . $timezone . '" ?>';
        file_put_contents($timezoneFile, $content);

        $notify[] = ['success', 'General setting updated successfully'];
        return back()->withNotify($notify);
    }

    public function systemConfiguration()
    {
        $pageTitle = 'System Configuration';
        return view('admin.setting.configuration', compact('pageTitle'));
    }

    public function systemConfigurationSubmit(Request $request)
    {
        $general                           = gs();
        $general->push_notify              = $request->push_notify ? Status::ENABLE : Status::DISABLE;
        $general->ev                       = $request->ev ? Status::ENABLE : Status::DISABLE;
        $general->en                       = $request->en ? Status::ENABLE : Status::DISABLE;
        $general->sv                       = $request->sv ? Status::ENABLE : Status::DISABLE;
        $general->sn                       = $request->sn ? Status::ENABLE : Status::DISABLE;
        $general->multi_language           = $request->multi_language ? Status::ENABLE : Status::DISABLE;
        $general->force_ssl                = $request->force_ssl ? Status::ENABLE : Status::DISABLE;
        $general->secure_password          = $request->secure_password ? Status::ENABLE : Status::DISABLE;
        $general->registration             = $request->registration ? Status::ENABLE : Status::DISABLE;
        $general->agree                    = $request->agree ? Status::ENABLE : Status::DISABLE;
        $general->is_enable_owner_request  = $request->is_enable_owner_request ? Status::ENABLE : Status::DISABLE;
        $general->save();
        $notify[] = ['success', 'System configuration updated successfully'];
        return back()->withNotify($notify);
    }

    public function maintenanceMode()
    {
        $pageTitle   = 'Maintenance Mode';
        $maintenance = Frontend::activeTemplate()->where('data_keys', 'maintenance.data')->firstOrFail();
        return view('admin.setting.maintenance', compact('pageTitle', 'maintenance'));
    }

    public function maintenanceModeSubmit(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'heading'     => 'required',
            'image'       => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $general                   = gs();
        $general->maintenance_mode = $request->status ? Status::ENABLE : Status::DISABLE;
        $general->save();

        $maintenance = Frontend::activeTemplate()->where('data_keys', 'maintenance.data')->firstOrFail();

        if ($request->hasFile('image')) {
            try {
                $path = getFilePath('maintenance');
                $size = getFileSize('maintenance');
                $imageName = fileUploader($request->image, $path, $size, @$maintenance->data_values->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }


        $dataValues  = [
            'description' => $request->description,
            'tempname'    => activeTemplateName(),
            'image'       => @$imageName ?? @$maintenance->data_values->image,
            'heading'     => $request->heading,
            'button_text' => $request->button_text,
        ];
        $maintenance->data_values = $dataValues;
        $maintenance->save();
        $notify[] = ['success', 'Maintenance mode updated successfully'];
        return back()->withNotify($notify);
    }

    public function logoIcon()
    {
        $pageTitle = 'Logo & Favicon';
        return view('admin.setting.logo_icon', compact('pageTitle'));
    }

    public function logoIconUpdate(Request $request)
    {
        $request->validate([
            'logo' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'logo_dark' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'favicon' => ['image', new FileTypeValidate(['png'])],
        ]);
        if ($request->hasFile('logo')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo)->save($path . '/logo.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('logo_dark')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo_dark)->save($path . '/logo_dark.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('favicon')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $size = explode('x', getFileSize('favicon'));
                Image::make($request->favicon)->resize($size[0], $size[1])->save($path . '/favicon.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the favicon'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'Logo & favicon updated successfully'];
        return back()->withNotify($notify);
    }

    public function customCss()
    {
        $pageTitle = 'Custom CSS';
        $file = activeTemplate(true) . 'css/custom.css';
        $fileContent = @file_get_contents($file);
        return view('admin.setting.custom_css', compact('pageTitle', 'fileContent'));
    }

    public function customCssSubmit(Request $request)
    {
        $file = activeTemplate(true) . 'css/custom.css';
        if (!file_exists($file)) {
            fopen($file, "w");
        }
        file_put_contents($file, $request->css);
        $notify[] = ['success', 'CSS updated successfully'];
        return back()->withNotify($notify);
    }

    public function cookie()
    {
        $pageTitle = 'GDPR Cookie';
        $cookie = Frontend::where('data_keys', 'cookie.data')->firstOrFail();
        return view('admin.setting.cookie', compact('pageTitle', 'cookie'));
    }

    public function cookieSubmit(Request $request)
    {
        $request->validate([
            'short_desc' => 'required',
            'description' => 'required',
        ]);
        $cookie = Frontend::where('data_keys', 'cookie.data')->firstOrFail();
        $cookie->data_values = [
            'short_desc' => $request->short_desc,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
        ];

        $cookie->save();
        $notify[] = ['success', 'Cookie policy updated successfully'];
        return back()->withNotify($notify);
    }
}
