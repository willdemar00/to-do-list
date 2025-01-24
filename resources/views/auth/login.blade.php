@extends('layouts.auth')

@section('title', 'Login')

@section('card-class', 'left')

@section('content')
<div class="card-login left">
    <div class="icon">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    <div class="title">
        <h1>TaskFlow</h1>
    </div>
    <p class="text-secondary fw-normal">Gerencie suas tarefas com eficiência</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="container">
            <div class="row w-75">
                <div class="col-md-12">
                    <label class="form-label" for="email">Email</label>
                    <x-input name="email" type="email" value="{{ old('email') }}" :attr="[
                        'class' => 'form-control',
                        'placeholder' => 'Email',
                        'id' => 'email',
                    ]" />
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="password">Senha</label>
                    <x-input type="password" name="password" value="{{ old('password') }}"
                        :attr="[
                            'class' => 'form-control',
                            'placeholder' => 'Senha',
                            'id' => 'password',
                        ]" />
                </div>
                <div class="col-md-6" style="display: flex; align-items: flex-start">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="" name="remember">
                        <span class="ms-2 text-sm color-secondary">{{ __('Lembrar-me') }}</span>
                    </label>
                </div>
                @if (Route::has('password.request'))
                <div class="text-center mb-3 color-secondary">
                    <a class="" href="{{ route('password.request') }}">{{ __('Esqueceu sua senha?') }}</a>
                </div>
                @endif
                <div class="col-md-12 flex justify-center">
                    <button class="btn btn-primary w-100" type="submit">Entrar</button>
                </div>
                <div class="col-md-12 text-center mt-3 d-md-none">
                    <a href="{{ route('register') }}">Não possui cadastro?</a>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="card-login right bg-primary d-none d-md-flex">
    <div class="text-white">
        <div class="conteiner">
            <div class="col-md-12 col align-items-center" style="text-align: center">
                <h1 class="mb-4">Bem-vindo ao TaskFlow!</h1>
                <p class="my-2">Registre-se agora para começar a organizar suas tarefas de forma fácil e eficiente!</p>
            </div>
            <div class="col-md-12 mt-3">
                <div class="d-flex justify-content-center align-items-center">
                    <a class="btn-outline" href="{{ route('register') }}">Registrar-se</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
