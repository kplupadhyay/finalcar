@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('owner_request.content', true);
        $elements = getContent('owner_request.element', orderById: true);
        $vendorContent = getContent('vendor_form_data.content', true);
    @endphp
    <section class="owner-request mt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center gy-sm-5 gy-4">
                <div class="col-lg-5">
                    <div class="get-facilities pe-lg-5">
                        <div class="section-heading style-left">
                            <h3 class="section-heading__title" s-break="-2">{{ __(@$content->data_values->heading) }}</h3>
                            <p class="section-heading__desc">{{ __(@$content->data_values->subheading) }}</p>
                        </div>
                        @foreach ($elements as $item)
                            <div class="get-facilities__item">
                                <span class="get-facilities__icon"> @php echo $item->data_values->icon; @endphp </span>
                                <div class="get-facilities__conent">
                                    <h6 class="get-facilities__title">{{ __($item->data_values->title) }}</h6>
                                    <p class="get-facilities__desc">{{ __($item->data_values->description) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="owner-form">
                        <div class="card custom--card custom--card--lg">
                            <div class="card-header bg-transparent">
                                <h4 class="title fw-bold mb-2">{{ __(@$content->data_values->form_title) }}</h4>
                                <p class="desc fs-14">{{ __(@$content->data_values->form_subtitle) }}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('vendor.send.form.data', session()->get('OWNER_ID') ?? 0) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <x-viser-form identifier="act" identifierValue="owner_form" />
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn--base w-100">@lang('Send Request')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
