@extends('admin.layouts.app')

@section('panel')
    <div class="row gy-4">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6">
                    <x-widget bg="info" icon="las la-wallet" style="3" title="Total Bookings" value="{{ $widget['total_bookings'] }}" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget bg="success" icon="las la-hotel" style="3" title="Running Bookings" value="{{ $widget['running_bookings'] }}" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget bg="warning" icon="las la-hotel" style="3" title="Booking Request" value="{{ $widget['booking_requests'] }}" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget bg="3" icon="las la-wallet" style="3" title="Total Payment" value="{{ $general->cur_sym . showAmount($widget['total_payment']) }}" />
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row gy-4">
                <div class="col-sm-6 col-lg-4">
                    <a class="btn btn--primary btn--shadow w-100 btn-lg" href="{{ route('admin.users.notification.log', $user->id) }}">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <a class="btn btn--info btn--shadow w-100 btn-lg" href="{{ route('admin.report.user.login.history') }}?search={{ $user->username }}">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="col-sm-6 col-lg-4">
                    @if ($user->status == Status::USER_ACTIVE)
                        <button class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-target="#userStatusModal" data-bs-toggle="modal" type="button">
                            <i class="las la-ban"></i>@lang('Ban User')
                        </button>
                    @else
                        <button class="btn btn--success btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-target="#userStatusModal" data-bs-toggle="modal" type="button">
                            <i class="las la-check"></i>@lang('Unban User')
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-content-center flex-wrap gap-2">
                    <h5 class="card-title">
                        @lang('Information of') {{ $user->fullname }}

                        @if ($user->deleted_at)
                            <span class="badge badge--danger">@lang('Deleted')</span>
                        @endif
                    </h5>
                    @if ($user->deleted_at)
                        <button class="btn btn-sm btn-outline--dark confirmationBtn" data-action="{{ route('admin.users.restore', $user->id) }}" data-question="@lang('Are you sure that you want to restore this user\'s account?')"><i class="las la-trash-restore-alt"></i>@lang('Restore')</button>
                    @else 
                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.users.delete', $user->id) }}" data-question="@lang('Are you sure that you want to delete this user\'s account?')"><i class="las la-trash-alt"></i>@lang('Delete Account')</button>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', [$user->id]) }}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" name="firstname" required type="text" value="{{ $user->firstname }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Last Name')</label>
                                    <input class="form-control" name="lastname" required type="text" value="{{ $user->lastname }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" name="email" required type="email" value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code"></span>
                                        <input class="form-control checkUser" id="mobile" name="mobile" required type="number" value="{{ old('mobile') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" name="address" type="text" value="{{ @$user->address->address }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" name="city" type="text" value="{{ @$user->address->city }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('State')</label>
                                    <input class="form-control" name="state" type="text" value="{{ @$user->address->state }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" name="zip" type="text" value="{{ @$user->address->zip }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Country')</label>
                                    <select class="form-control" name="country">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xl-6 col-md-6 col-sm-3 col-12">
                                <label>@lang('Email Verification')</label>
                                <input @if ($user->ev) checked @endif data-bs-toggle="toggle" data-off="@lang('Unverified')" data-offstyle="-danger" data-on="@lang('Verified')" data-onstyle="-success" data-width="100%" name="ev" type="checkbox">

                            </div>

                            <div class="form-group col-xl-6 col-md-6 col-sm-3 col-12">
                                <label>@lang('Mobile Verification')</label>
                                <input @if ($user->sv) checked @endif data-bs-toggle="toggle" data-off="@lang('Unverified')" data-offstyle="-danger" data-on="@lang('Verified')" data-onstyle="-success" data-width="100%" name="sv" type="checkbox">

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userStatusModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($user->status == Status::USER_ACTIVE)
                            <span>@lang('Ban User')</span>
                        @else
                            <span>@lang('Unban User')</span>
                        @endif
                    </h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($user->status == Status::USER_ACTIVE)
                            <h6 class="mb-2">@lang('If you ban this user he/she won\'t able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" required rows="4"></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $user->ban_reason }}</p>
                            <h4 class="text-center mt-3">@lang('Are you sure to unban this user?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($user->status == Status::USER_ACTIVE)
                            <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                        @else
                            <button class="btn btn--dark" data-bs-dismiss="modal" type="button">@lang('No')</button>
                            <button class="btn btn--primary" type="submit">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('script')
    <script>
        (function($) {
            "use strict"

            let mobileElement = $('.mobile-code');
            $('select[name=country]').change(function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });
            $('select[name=country]').val('{{ @$user->country_code }}');
            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ $user->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);
        })(jQuery);
    </script>
@endpush
