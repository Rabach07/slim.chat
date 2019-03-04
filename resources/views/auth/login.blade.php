@extends('master')

@section('content')
    <div class="w-1/3 mx-auto card">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="group">
                <label>Email</label>
                <input type="email" name="email" class="input" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <p class="text-red">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="group">
                <label>Password</label>
                <input type="password" name="password" class="input" required>
                @if ($errors->has('password'))
                    <p class="text-red">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="actions">
                <a class="button link" href="{{ route('password.request') }}">
                    Forgot password
                </a>
                <button type="submit" class="button green">
                    Log in
                </button>
            </div>
        </form>
    </div>
@endsection
