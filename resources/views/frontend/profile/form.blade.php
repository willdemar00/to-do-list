@extends('frontend.app')

@section('title', 'Perfil')
@section('styles')
    <style>
        .img-placeholder {
            border: 2px dashed var(--primary-color);
            border-radius: 50%;
            width: 150px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            padding: 3px;
        }

        .img-placeholder p {
            font-size: .8em;
        }

        .img-placeholder img {
            width: 141px;
            height: 141px;
            object-fit: cover;
            border-radius: 50%;
        }

        .img-placeholder span {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .img-placeholder span>i {
            background-color: #cbcbcba2;
            padding: 10px 11px;
            border-radius: 50%;
        }

        .container-form {
            display: flex;
            justify-content: space-between;
        }

        .container-img {
            background-color: var(--bg-light-gray);
            border-radius: 50%;
        }

        .grid {
            display: grid;
            align-items: flex-start;
            grid-template-columns: 150px 1fr;
            width: 100%;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
                justify-items: center;

            }
        }
    </style>
@endsection

@section('content')

<div class="container">
        <div class="row">
            <div class="col-md-12">
                <x-breadcrumb :items="[['name' => 'Início', 'route' => route('home')], ['name' => 'Perfil']]" />
            </div>
            <div class="col-md-12">
                <h3>Perfil</h3>
            </div>
        </div>
        <div class="card card-body p-4">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mb-2">Informações pessoais</h6>
                </div>
                <hr>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    <div class="grid">
                        <x-input-img :user="$user" />
                        <div class="row">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label for="name" class="form-label">Nome</label>
                                <x-input name="name" type="text" :value="old('name', $user->name)" :attr="['class' => 'form-control', 'autocomplete' => 'name']" />
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <x-input name="email" type="email" :value="old('email', $user->email)" :attr="['class' => 'form-control', 'autocomplete' => 'username']" />
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="card card-body p-4">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mb-2">Alterar senha</h6>
                </div>
                <hr>
                <div class="row">
                    <form method="POST" action="{{ route('profile.update.password') }}">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <label for="current_password" class="form-label">Senha atual</label>
                            <x-input name="current_password" type="password" :attr="[
                                'class' => 'form-control',
                                'autocomplete' => 'current-password',
                                'placeholder' => 'Senha atual',
                            ]" />
                        </div>
                        <div class="col-md-12">
                            <label for="new_password" class="form-label">Nova senha</label>
                            <x-input name="new_password" type="password" :attr="[
                                'class' => 'form-control',
                                'autocomplete' => 'new-password',
                                'placeholder' => 'Senha nova',
                            ]" />
                        </div>
                        <div class="col-md-12">
                            <label for="new_password_confirmation" class="form-label">Confirmar nova senha</label>
                            <x-input name="new_password_confirmation" type="password" :attr="[
                                'class' => 'form-control',
                                'autocomplete' => 'new-password',
                                'placeholder' => 'Confirmar senha',
                            ]" />
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="alert danger mt-3" role="alert">
            <div class="icon">
                <i class="fa-solid fa-exclamation-triangle"></i>
            </div>
            <div>
                <strong>Excluir conta</strong>
                <p class="mb-1">Ao excluir sua conta, todos os seus dados serão permanentemente removidos. Esta ação não
                    pode ser desfeita.</p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Excluir minha conta
                </button>
            </div>

        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirmar exclusão de Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja excluir sua conta? Esta ação não pode ser desfeita.
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <x-input name="password" type="password" :attr="['class' => 'form-control', 'required', 'autocomplete' => 'current-password']" />
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script src="{{ asset('assets/js/file.js') }}"></script>
    @endsection
