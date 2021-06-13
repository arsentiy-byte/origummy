@extends('layouts.app')

@push('styles')
    <link href="{{ mix($stylesheet ?? 'css/admin.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
@endpush

@section('content')
    @component('components.full-page-section')



        @component('components.card')
            @slot('title')
                <span class="icon"><i class="mdi mdi-lock"></i></span>
                <span>{{ __('Login') }}</span>
            @endslot
            @if(session()->has('error'))
                <div class="alert alert-danger" style="color: red;">
                    {{ session()->get('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('web-auth-login') }}">
                @csrf

                <div class="field">
                    <label class="label" for="username">{{ __('Username') }}</label>
                    <div class="control">
                        <input id="username" type="string" class="input @error('username') is-danger @enderror" name="username" value="{{ old('username') }}" required autofocus>
                    </div>
                    @error('username')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password">{{ __('Password') }}</label>
                    <div class="control">
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="current-password" autofocus>
                    </div>
                    @error('password')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <hr>

                <div class="field is-form-action-buttons">
                    <button type="submit" class="button is-black">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        @endcomponent
    @endcomponent
@endsection
