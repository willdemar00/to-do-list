@extends('frontend.auth')

@section('title', 'Forgot Password')
@section('styles')
    <style>
        .conatiner-card {
            display: flex !important;
            padding: 30px;
            flex-direction: column;
        }

        .mobile-container {
            width: 50%;
            margin: auto;
            padding: 10px;
        }

        @media (max-width: 768px) {
            .mobile-container {
                width: 100%;
                margin: auto;
                padding: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class="icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="title">
            <h1>TaskFlow</h1>
        </div>
    </div>
    <div class="mobile-container">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label class="form-label" for="email">Email</label>
                <input id="email" class="form-control" type="email" name="email"
                    value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label class="form-label" for="password">Senha</label>
                <input id="password" class="form-control" type="password" name="password" required
                    autocomplete="new-password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label class="form-label" for="password_confirmation">Confirmar Senha</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required
                    autocomplete="new-password">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="btn btn-primary" type="submit">Redefinir Senha</button>
            </div>
        </form>
    </div>
@endsection
