@extends('frontend.auth')

@section('title', 'Confirm Password')
@section('styles')
    <style>
        .conatiner-card {
            display: flex !important;
            padding: 30px;
            flex-direction: column;
        }
    </style>
@endsection

@section('content')
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <label class="form-label" for="password">Senha</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end mt-4">
            <button class="btn btn-primary" type="submit">Confirmar</button>
        </div>
    </form>
@endsection
