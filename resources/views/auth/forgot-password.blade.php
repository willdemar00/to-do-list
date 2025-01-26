@extends('frontend.auth')

@section('title', 'Forgot Password')
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
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class="icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="title">
            <h1>TaskFlow</h1>
        </div>
    </div>
    <div style="">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
            {{ __('Esqueceu sua senha? Informe seu e-mail e enviaremos um link para redefinição.') }}
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label class="form-label" for="email">Email</label>
                <x-input name="email" type="email" value="{{ old('email') }}" :attr="[
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    'id' => 'email',
                ]" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="btn btn-primary w-100"
                    type="submit">{{ __('Enviar link de redefinição de senha') }}</button>
            </div>
        </form>
    </div>
@endsection
