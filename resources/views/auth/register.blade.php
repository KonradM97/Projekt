@extends('layouts.app2')

@section('content')

<section class="login text-center">
    <div class="container">
        <h2>{{ __('Register') }}</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="login-form-control">
                <input id="name" type="text" placeholder="Nazwa" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="login-form-control">
                <input id="email" type="email" placeholder="E-mail" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="login-form-control">
                <input id="password" type="password" placeholder="Hasło" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="login-form-control">
                <input id="password-confirm" type="password" placeholder="Powtórz hasło" name="password_confirmation" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-secondary">
                {{ __('Register') }}
            </button>
        </form>
    </div>
</section>

@endsection
