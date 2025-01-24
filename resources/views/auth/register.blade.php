@extends('layouts.auth')

@section('title', 'Register')

@section('card-class', 'right')

@section('content')
<div class="card-login left p-5 bg-primary d-none d-md-flex">
    <div class="text-white">
        <div class="conteiner">
            <div class="col-md-12 col align-items-center" style="text-align: center">
                <h1 class="mb-4">Bem-vindo de volta!</h1>
                <p class="my-2">Faça login para acessar sua conta.</p>
            </div>
            <div class="col-md-12 mt-3">
                <div class="d-flex justify-content-center align-items-center">
                    <a class="btn-outline" href="{{ route('login') }}">Entrar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-login right">
    <div class="icon">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    <div class="title">
        <h1>TaskFlow</h1>
    </div>
    <p class="text-secondary fw-normal">Registre-se agora e crie sua conta de acesso</p>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="container">
            <div class="row w-75">
                <div class="col-md-12">
                    <label class="form-label" for="name">Nome do usuário</label>
                    <x-input name="name" type="text" value="{{ old('name') }}" :attr="[
                        'class' => 'form-control',
                        'placeholder' => 'Nome do usuário',
                        'id' => 'name',
                    ]" />
                </div>
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
                    <x-input name="password" type="password" value="{{ old('password') }}" :attr="[
                        'class' => 'form-control',
                        'placeholder' => 'Senha',
                        'id' => 'password',
                    ]" />
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="password_confirmation">Confirmar senha</label>
                    <x-input name="password_confirmation" type="password" value="{{ old('password_confirmation') }}" :attr="[
                        'class' => 'form-control',
                        'placeholder' => 'Confirmar senha',
                        'id' => 'password_confirmation',
                    ]" />
                </div>
                <div class="col-md-12 flex justify-center mt-4">
                    <button class="btn btn-primary w-100" type="submit">Registrar-se</button>
                </div>
                <div class="col-md-12 text-center mt-3 d-md-none">
                    <a href="{{ route('login') }}">Já possuo cadastro</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
