@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="image-upload">
                                    <label>@lang('Maintenance Mode Image')</label>
                                    <x-image-uploader class="w-100" imagePath="{{ getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance')) }}" type="maintenance" :required="false"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('Status')</label>
                                            <input @if (@$general->maintenance_mode) checked @endif data-bs-toggle="toggle" data-height="50" data-off="@lang('Disabled')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-width="100%" name="status" type="checkbox">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('Heading')</label>
                                            <input class="form-control" name="heading" required type="text" value="{{ @$maintenance->data_values->heading }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('Description')</label>
                                            <textarea class="form-control nicEdit" name="description" rows="10">@php echo @$maintenance->data_values->description @endphp</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
