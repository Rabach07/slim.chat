@extends('master')

@section('content')
    <div class="w-1/3 mx-auto card">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="group">
                <label>Name</label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <p class="text-red">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <p class="text-red">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="group">
                <div class="flex">
                    <div class="flex-1 mr-1">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="flex-1 ml-1">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                </div>

                @if ($errors->has('password'))
                    <p class="text-red">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="actions">
                <button type="submit" class="green">
                    Sign Up
                </button>
            </div>
        </form>
    </div>
@endsection
