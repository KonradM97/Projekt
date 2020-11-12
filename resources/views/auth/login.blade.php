@extends('layouts.app2')

@section('content')
<!--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
@@ -70,4 +71,49 @@
        </div>
    </div>
</div>
-->

<section class="login text-center">
    <div class="container">
        <h2>{{ __('Login') }}</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="login-form-control">
                <input id="email" type="email" placeholder="E-mail" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="login-form-control">
                <input id="password" type="password" placeholder="Hasło" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

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
                <a class="btn btn-secondary" href="{{ route('password.request') }}">
<<<<<<< HEAD
                    {{ __('Zapomniane hasło?') }}
=======
                    {{ __('Forgot Your Password?') }}
>>>>>>> 6482298349b823b795641b0be72eab2642f0e4d0
                </a>
            @endif
        </form>
    </div>
</section>

<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> 6482298349b823b795641b0be72eab2642f0e4d0
