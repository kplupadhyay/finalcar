@extends('admin.layouts.app')
@section('panel')
    <div class="row ">
        <div class="col-md-12 mb-30">
            <div class="card bl--5-primary">
                <div class="card-body">
                    <p class="fw-bold text--info">@lang('If the logo and favicon are not changed after you update from this page, please clear the cache from your browser. As we keep the filename the same after the update, it may show the old image for the cache. usually, it works after clear the cache but if you still see the old logo or favicon, it may be caused by server level or network level caching. Please clear them too.')</p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-6">
                                <label> @lang('Logo for White Background')</label>
                                <x-image-uploader :imagePath="siteLogo('dark') . '?' . time()" :required="false" :size="false" class="w-100" id="uploadWhiteBG" name="logo_dark" />
                            </div>
                            <div class="form-group col-md-4 col-sm-6">
                                <label> @lang('Logo for Dark Background')</label>
                                <x-image-uploader :imagePath="siteLogo() . '?' . time()" :required="false" :size="false" class="w-100 bg--dark" id="uploadDarkBG" name="logo" />
                            </div>
                            <div class="form-group col-md-4 col-sm-6">
                                <label> @lang('Favicon')</label>
                                <x-image-uploader :imagePath="siteFavicon() . '?' . time()" :required="false" :size="false" class="w-100" id="uploadFavicon" name="favicon" />
                            </div>
                        </div>
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .image-upload-preview {
            background-size: contain;
            overflow: hidden;
        }
    </style>
@endpush
