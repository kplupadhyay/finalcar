@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="cta congratulations ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="process">
                        <div class="process-content">
                            <img alt="@lang('congrats')" src="{{ getImage('assets/images/congrats.png') }}" />
                            <h3><i class="las la-smile"></i> @lang('Congratulations')</h3>
                            <h6>@lang('Your registration process has been completed. Please wait for admin response.')</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        "use strict";
        (function ($) {
            $(".page-title-section").remove();
        })(jQuery);
    </script>
@endpush