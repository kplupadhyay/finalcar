@extends('owner.layouts.app')
@section('panel')
    <div class="notify__area">
        @forelse($notifications as $notification)
            <a class="notify__item @if ($notification->is_read == Status::NO) unread--notification @endif" href="@if (can('owner.notification.read')) {{ route('owner.notification.read', $notification->id) }} @else javascript:void(0) @endif">
                <div class="notify__content">
                    <h6 class="title">{{ __($notification->title) }}</h6>
                    <span class="date"><i class="las la-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
                </div>
            </a>
        @empty
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">{{ __($emptyMessage) }}</h3>
                </div>
            </div>
        @endforelse
        <div class="mt-3">
            {{ paginateLinks($notifications) }}
        </div>
    </div>
@endsection
@can('owner.notifications.readAll')
    @push('breadcrumb-plugins')
        <a class="btn btn-sm btn-outline--primary" href="{{ route('owner.notifications.readAll') }}">@lang('Mark All as Read')</a>
    @endpush
@endcan
