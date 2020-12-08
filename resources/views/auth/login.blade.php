@extends('layouts.app2')

@section('content')

<section class="login text-center">
    <div class="container">
        <h2>{{ __('Login') }}</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="login-form-control">
                <input id="email" type="email" placeholder="E-mail" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <br />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="login-form-control">
                <input id="password" type="password" placeholder="Hasło" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <br />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="login-form-control">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <button type="submit" class="btn btn-secondary">
                {{ __('Login') }}
            </button>

            @if (Route::has('password.request'))
                <button class="btn btn-secondary"><a href="{{ route('password.request') }}">
                    {{ __('Zapomniane hasło?') }}
                    {{ __('Forgot Your Password?') }}

                </a></button>
            @endif
        </form>
    </div>
</section>


@endsection
