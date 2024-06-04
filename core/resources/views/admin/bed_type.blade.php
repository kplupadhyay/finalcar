@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Bed Type')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bedTypes as $item)
                                    <tr>
                                        <td><span class="me-2">{{ $bedTypes->firstItem() + $loop->index }}.</span>{{ __($item->name) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Update Bed Type')" data-resource="{{ $item }}" type="button">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($bedTypes->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($bedTypes) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.hotel.bed.save') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> @lang('Bed Type')</label>
                            <input class="form-control" name="name" required type="text" value="{{ old('type_name') }}">
                        </div>
                        <div class="status"></div>
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
    <button class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Bed Type')" type="button">
        <i class="las la-plus"></i>@lang('Add New ')
    </button>
@endpush
