@extends('layouts.app')

@push('html-class') has-spinner-active has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded @endpush

@push('head-scripts')
    <script src="{{ mix('js/admin.js') }}" defer></script>
@endpush

@push('styles')
    <link href="{{ mix($stylesheet ?? 'css/admin.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
@endpush

@push('bottom')
    <form id="logout-form" action="{{ route('web-auth-logout') }}" method="GET" style="display: none;">
        @csrf
    </form>
@endpush
