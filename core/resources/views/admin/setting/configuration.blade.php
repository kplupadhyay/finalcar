@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.setting.system.configuration.submit') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('User Registration')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you disable this module, no one can register on this system')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->registration) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="registration" type="checkbox">
                                </div>
                            </li>
                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Force SSL')</p>
                                    <p class="mb-0">
                                        <small>@lang('By enabling') <span class="fw-bold">@lang('Force SSL (Secure Sockets Layer)')</span>
                                            @lang('the system will force a visitor that he/she must have to visit in secure mode. Otherwise, the site will be loaded in secure mode.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->force_ssl) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="force_ssl" type="checkbox">
                                </div>
                            </li>
                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Agree Policy')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, that means a user must have to agree with your system\'s') <a href="{{ route('admin.frontend.sections', 'policy_pages') }}">@lang('policies')</a>
                                            @lang('during registration.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->agree) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="agree" type="checkbox">
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Force Secure Password')</p>
                                    <p class="mb-0">
                                        <small>@lang('By enabling this module, a user must set a secure password while signing up or changing the password.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->secure_password) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="secure_password" type="checkbox">
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Email Verification')</p>
                                    <p class="mb-0">
                                        <small>
                                            @lang('If you enable') <span class="fw-bold">@lang('Email Verification')</span>,
                                            @lang('users have to verify their email to access the dashboard. A 6-digit verification code will be sent to their email to be verified.')
                                            <br>
                                            <span class="fw-bold"><i>@lang('Note'):</i></span> <i>@lang('Make sure that the')
                                                <span class="fw-bold">@lang('Email Notification') </span> @lang('module is enabled')</i>
                                        </small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->ev) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="ev" type="checkbox">
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Email Notification')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, the system will send emails to users where needed. Otherwise, no email will be sent.') <code>@lang('So be sure before disabling this module that, the system doesn\'t need to send any emails.')</code></small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->en) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="en" type="checkbox">
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Mobile Verification')</p>
                                    <p class="mb-0">
                                        <small>
                                            @lang('If you enable') <span class="fw-bold">@lang('Mobile Verification')</span>,
                                            @lang('users have to verify their mobile to access the dashboard. A 6-digit verification code will be sent to their mobile to be verified.')
                                            <br>
                                            <span class="fw-bold"><i>@lang('Note'):</i></span> <i>@lang('Make sure that the')
                                                <span class="fw-bold">@lang('SMS Notification') </span> @lang('module is enabled')</i>
                                        </small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->sv) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="sv" type="checkbox">
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('SMS Notification')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, the system will send SMS to users where needed. Otherwise, no SMS will be sent.') <code>@lang('So be sure before disabling this module that, the system doesn\'t need to send any SMS.')</code></small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->sn) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="sn" type="checkbox">
                                </div>
                            </li>
                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Language Option')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, users can change the language according to their needs')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->multi_language) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="multi_language" type="checkbox">
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Push Notification')</p>
                                    <p class="mb-0">
                                        <small>
                                            @lang('If you enable this module, the system will send push notifications to users. Otherwise, no push notification will be sent.')
                                            <a href="{{ route('admin.setting.notification.push') }}">@lang('Setting here')</a>
                                        </small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->push_notify) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="push_notify" type="checkbox">
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Owner Request')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, visitors can send request as owner, otherwise can\'t.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input @if ($general->is_enable_owner_request) checked @endif data-bs-toggle="toggle" data-height="35" data-off="@lang('Disable')" data-offstyle="-danger" data-on="@lang('Enable')" data-onstyle="-success" data-size="large" data-width="100%" name="is_enable_owner_request" type="checkbox">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .toggle.btn-lg {
            height: 37px !important;
            min-height: 37px !important;
        }

        .toggle-handle {
            width: 25px !important;
            padding: 0;
        }

        .form-group {
            width: 125px;
            margin-bottom: 0;
            flex-shrink: 0
        }

        .list-group-item:hover {
            background-color: #F7F7F7;
        }
    </style>
@endpush
