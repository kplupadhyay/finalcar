@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.frontend.sections.content', $key) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input name="type" type="hidden" value="element">
                        @if (@$data)
                            <input name="id" type="hidden" value="{{ $data->id }}">
                        @endif
                        <div class="row">
                            @php
                                $imgCount = 0;
                            @endphp
                            @foreach ($section->element as $k => $content)
                                @if ($k == 'images')
                                    @php
                                        $imgCount = collect($content)->count();
                                    @endphp
                                    @foreach ($content as $imgKey => $image)
                                        <div class="col-md-4">
                                            <input name="has_image[]" type="hidden" value="1">
                                            <div class="form-group">
                                                <label>{{ __(keyToTitle($imgKey)) }}</label>

                                                <x-image-uploader :imagePath="getImage('assets/images/frontend/' . $key . '/' . @$data->data_values->$imgKey, @$section->element->images->$imgKey->size)" :required="false" :size="$section->element->images->$imgKey->size" class="w-100" id="image-upload-input{{ $loop->index }}" name="image_input[{{ @$imgKey }}]" />

                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="@if ($imgCount > 1) col-md-12 @else col-md-8 @endif">
                                        @push('divend')
                                        </div>
                                    @endpush
                                @elseif($content == 'icon')
                                    <div class="form-group">
                                        <label>{{ keyToTitle($k) }}</label>
                                        <div class="input-group">
                                            <input autocomplete="off" class="form-control iconPicker icon" name="{{ $k }}" required type="text">
                                            <span class="input-group-text  input-group-addon" data-icon="las la-home" role="iconpicker"></span>
                                        </div>
                                    </div>
                                @else
                                    @if ($content == 'textarea')
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __(keyToTitle($k)) }}</label>
                                                <textarea class="form-control" name="{{ $k }}" required rows="10">{{ @$data->data_values->$k }}</textarea>
                                            </div>
                                        </div>
                                    @elseif($content == 'textarea-nic')
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __(keyToTitle($k)) }}</label>
                                                <textarea class="form-control nicEdit" name="{{ $k }}" rows="10">{{ @$data->data_values->$k }}</textarea>
                                            </div>
                                        </div>
                                    @elseif($k == 'selects')
                                        @foreach ($content as $selectKey => $selectValue)
                                            @php
                                                $selectName = $selectValue->name;
                                            @endphp
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{ __(keyToTitle(@$selectName)) }}</label>
                                                    <select class="form-control" name="{{ @$selectName }}" required>
                                                        @foreach ($selectValue->options as $selectItemKey => $selectOption)
                                                            <option @if (@$data->data_values->$selectName == $selectItemKey) selected @endif value="{{ $selectItemKey }}">{{ __($selectOption) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __(keyToTitle($k)) }}</label>
                                                <input class="form-control" name="{{ $k }}" required type="text" value="{{ @$data->data_values->$k }}" />
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                            @stack('divend')
                        </div>

                        <div class="form-group">
                            <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
        <x-back route="{{ route('admin.frontend.sections', $key) }}"></x-back>
    </div>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
                $(this).closest('.form-group').find('.iconpicker-input').val(`<i class="${e.iconpickerValue}"></i>`);
            });
        })(jQuery);
    </script>
@endpush
