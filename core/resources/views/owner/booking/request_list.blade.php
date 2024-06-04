@extends('owner.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.') </th>
                                    <th>@lang('Username') | @lang('Email')</th>
                                    <th>@lang('Booked For') | @lang('Room Qty')</th>
                                    <th>@lang('Check In') | @lang('Check Out')</th>
                                    <th>@lang('Amount')</th>
                                    @can(['owner.request.booking.approve', 'owner.request.booking.cancel'])
                                        <th>@lang('Action')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookingRequests as $bookingRequest)
                                    <tr>
                                        <td> {{ $bookingRequests->firstItem() + $loop->index }}</td>
                                        <td>
                                            <span class="small">
                                                {{ $bookingRequest->user->username }}
                                            </span>
                                            <br>
                                            <span>+{{ $bookingRequest->user->mobile }}</span>
                                        </td>

                                        <td>
                                            {{ $bookingRequest->bookFor() }} @lang('Night')
                                            <br>
                                            <span>
                                                {{ $bookingRequest->totalRoom() }} @lang('Room')
                                            </span>
                                        </td>

                                        <td>
                                            {{ showDateTime($bookingRequest->check_in, 'd M, Y') }}
                                            <br>
                                            {{ showDateTime($bookingRequest->check_out, 'd M, Y') }}
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ __($general->cur_sym) . showAmount($bookingRequest->total_amount) }}</span>
                                        </td>

                                        @can(['owner.request.booking.approve', 'owner.request.booking.cancel'])
                                            <td>
                                                @can('owner.request.booking.approve')
                                                    <a class="btn btn-sm btn-outline--success ms-1" href="{{ route('owner.request.booking.approve', $bookingRequest->id) }}"><i class="las la-check"></i>@lang('Approve')</a>
                                                @endcan

                                                @can('owner.request.booking.cancel')
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn ms-1" data-action="{{ route('owner.request.booking.cancel', $bookingRequest->id) }}" data-question="@lang('Are you sure, you want to cancel this booking request?')">
                                                        <i class="las la-times-circle"></i>@lang('Cancel')
                                                    </button>
                                                @endcan
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($bookingRequests->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($bookingRequests) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @can('owner.request.booking.cancel')
        <x-confirmation-modal />
    @endcan
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="User/Email" />
    @can('owner.booking.active')
        <a class="btn btn--success" href="{{ route('owner.booking.active') }}"><i class="las la-check-circle"></i>@lang('Active Bookings')</a>
    @endcan
@endpush
