@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Code')</th>
                                    <th>@lang('Dial Code')</th>
                                    <th>@lang('Cities')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($countries as $country)
                                    <tr>
                                        <td>
                                            <span class="me-2"> {{ $countries->firstItem() + $loop->index }}.</span>{{ __($country->name) }}
                                        </td>
                                        <td>{{ __($country->code) }}</td>
                                        <td>+{{ __($country->dial_code) }}</td>
                                        <td>
                                            <a href="{{ route('admin.location.city.all') }}?search={{ $country->name }}"><span class="badge badge--primary">{{ $country->total_city }}</span></a>
                                        </td>
                                        <td>@php echo $country->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button-group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $country }}" data-modal_title="@lang('Update Country')" type="button"><i class="las la-pencil-alt"></i>@lang('Edit')</button>
                                                @if ($country->status == Status::DISABLE)
                                                    <button class="btn btn-sm btn-outline--success me-1 confirmationBtn" data-action="{{ route('admin.location.country.status.update', $country->id) }}" data-question="@lang('Are you sure to enable this facility?')" type="button">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.location.country.status.update', $country->id) }}" data-question="@lang('Are you sure to disable this facility?')" type="button">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($countries->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($countries) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.location.country.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Code')</label>
                            <input type="text" class="form-control" name="code" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Dial Code')</label>
                            <input type="text" class="form-control" name="dial_code" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn h-45 w-100 btn--primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Country')" type="button"><i class="las la-plus"></i>@lang('Add New')</button>
    <x-search-form />
@endpush
