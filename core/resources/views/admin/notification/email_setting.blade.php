@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label class="mb-4">@lang('Email Send Method')</label>
                            <select class="form-control" name="email_method">
                                <option @if ($general->mail_config->name == 'php') selected @endif value="php">@lang('PHP Mail')</option>
                                <option @if ($general->mail_config->name == 'smtp') selected @endif value="smtp">@lang('SMTP')</option>
                                <option @if ($general->mail_config->name == 'sendgrid') selected @endif value="sendgrid">@lang('SendGrid API')</option>
                                <option @if ($general->mail_config->name == 'mailjet') selected @endif value="mailjet">@lang('Mailjet API')</option>
                            </select>
                        </div>
                        <div class="row mt-4 d-none configForm" id="smtp">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('SMTP Configuration')</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Host') </label>
                                    <input class="form-control" name="host" placeholder="e.g. @lang('smtp.googlemail.com')" type="text" value="{{ $general->mail_config->host ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Port') </label>
                                    <input class="form-control" name="port" placeholder="@lang('Available port')" type="text" value="{{ $general->mail_config->port ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Encryption')</label>
                                    <select class="form-control" name="enc">
                                        <option value="ssl" @selected(@$general->mail_config->enc == 'ssl')>@lang('SSL')</option>
                                        <option value="tls" @selected(@$general->mail_config->enc == 'tls')>@lang('TLS')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Username') </label>
                                    <input class="form-control" name="username" placeholder="@lang('Normally your email') address" type="text" value="{{ $general->mail_config->username ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Password') </label>
                                    <input class="form-control" name="password" placeholder="@lang('Normally your email password')" type="text" value="{{ $general->mail_config->password ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="sendgrid">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('SendGrid API Configuration')</h6>
                            </div>
                            <div class="form-group col-md-12">
                                <label>@lang('App Key') </label>
                                <input class="form-control" name="appkey" placeholder="@lang('SendGrid App key')" type="text" value="{{ $general->mail_config->appkey ?? '' }}" />
                            </div>
                        </div>
                        <div class="row mt-4 d-none configForm" id="mailjet">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Mailjet API Configuration')</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Api Public Key') </label>
                                    <input class="form-control" name="public_key" placeholder="@lang('Mailjet Api Public Key')" type="text" value="{{ $general->mail_config->public_key ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Api Secret Key') </label>
                                    <input class="form-control" name="secret_key" placeholder="@lang('Mailjet Api Secret Key')" type="text" value="{{ $general->mail_config->secret_key ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>

    </div>

    <div class="modal fade" id="testMailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Test Mail Setup')</h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.setting.notification.email.test') }}" method="POST">
                    @csrf
                    <input name="id" type="hidden">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Sent to') </label>
                                    <input class="form-control" name="email" placeholder="@lang('Email Address')" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary" data-bs-target="#testMailModal" data-bs-toggle="modal" type="button"><i class="las la-paper-plane"></i> @lang('Send Test Mail')</button>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            var method = '{{ $general->mail_config->name }}';
            emailMethod(method);
            $('select[name=email_method]').on('change', function() {
                var method = $(this).val();
                emailMethod(method);
            });

            function emailMethod(method) {
                $('.configForm').addClass('d-none');
                if (method != 'php') {
                    $(`#${method}`).removeClass('d-none');
                }
            }

        })(jQuery);
    </script>
@endpush
