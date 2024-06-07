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
                                    <th>@lang('Hotel')</th>
                                    <th>@lang('Location')</th>
                                    <th>@lang('Vendor')</th>
                                    <th>@lang('Phone') | @lang('Email')</th>
                                    <th>@lang('Joined At')</th>
                                    <th>@lang('Is Featured')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($owners as $owner)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ @$owner->hotelSetting->name }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <span>
                                                    {{ __(@$owner->hotelSetting->location->name) }}, {{ __(@$owner->hotelSetting->city->name) }}
                                                </span><br>
                                                <span>{{ __(@$owner->hotelSetting->country->name) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.owners.detail', $owner->id) }}">{{ $owner->fullname }}</a>
                                        </td>
                                        <td>
                                            <span class="fw-bold">+{{ $owner->mobile }}</span> <br>
                                            <span class="fw-bold">{{ $owner->email }}</span>
                                        </td>
                                        <td>
                                            {{ showDateTime($owner->created_at) }} <br> {{ diffForHumans($owner->created_at) }}
                                        </td>
                                        <td>@php echo $owner->featureBadge @endphp</td>

                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.owners.detail', $owner->id) }}">
                                                    <i class="las la-desktop"></i>@lang('Details')
                                                </a>

                                                @if (!Route::is('admin.owners.banned'))
                                                    @if ($owner->is_featured)
                                                        <button class="btn btn-sm btn-outline--dark confirmationBtn" data-question="@lang('Are you sure, you want to unfeature this vendor?')" data-action="{{ route('admin.owners.feature.status.update', $owner->id) }}"><i class="las la-times"></i>@lang('Unfeature')</button>
                                                    @else
                                                        <button class="btn btn-sm btn-outline--success confirmationBtn" data-question="@lang('Are you sure, you want to featured this vendor?')" data-action="{{ route('admin.owners.feature.status.update', $owner->id) }}"><i class="las la-check"></i>@lang('Feature')</button>
                                                    @endif
                                                @endif
                                            </div>
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
                @if ($owners->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($owners) }}
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
