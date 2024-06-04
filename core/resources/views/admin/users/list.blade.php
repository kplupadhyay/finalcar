@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Email') - @lang('Phone')</th>
                                    <th>@lang('Country')</th>
                                    <th>@lang('Joined At')</th>
                                    @if (Route::is('admin.users.deleted'))
                                        <th>@lang('Deleted At')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                            @if ($user->mobile)
                                                <br> +{{ $user->mobile }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold" title="{{ @$user->address->country }}">{{ $user->country_code ?? '...' }}</span>
                                        </td>
                                        <td>
                                            {{ showDateTime($user->created_at) }} <br> {{ diffForHumans($user->created_at) }}
                                        </td>
                                        @if (Route::is('admin.users.deleted'))
                                            <td>
                                                {{ showDateTime($user->deleted_at) }} <br> {{ diffForHumans($user->deleted_at) }}
                                            </td>
                                        @endif
                                        <td>
                                            <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.users.detail', $user->id) }}">
                                                <i class="las la-desktop"></i> @lang('Details')
                                            </a>

                                            @if (Route::is('admin.users.deleted'))
                                                <button class="btn btn-sm btn-outline--dark confirmationBtn" data-action="{{ route('admin.users.restore', $user->id) }}" data-question="@lang('Are you sure that you want to restore this user\'s account?')"><i class="las la-trash-restore-alt"></i>@lang('Restore')</button>
                                            @else
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.users.delete', $user->id) }}" data-question="@lang('Are you sure that you want to delete this user\'s account?')"><i class="las la-trash-alt"></i>@lang('Delete')</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($users) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush
