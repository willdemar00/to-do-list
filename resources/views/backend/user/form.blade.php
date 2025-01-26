@extends('frontend.app')

@section('title', 'Adicionar Usuário')

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
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <x-breadcrumb :items="[['name' => 'Início', 'route' => route('home')], ['name' => 'Usuários', 'route' => route('user.index')], ['name' => 'Adicionar Usuário']]" />
            </div>
            <div class="col-md-12">
                <h3>Adicionar Usuário</h3>
            </div>
        </div>
        <div class="card card-body p-4">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mb-2">Informações Pessoais</h6>
                </div>
                <hr>
                <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                    <div class="grid">
                        <x-input-img />
                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nome</label>
                                <x-input name="name" type="text" :value="old('name', )" :attr="['class' => 'form-control', 'autocomplete' => 'name']" />
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <x-input name="email" type="email" :value="old('email')" :attr="['class' => 'form-control', 'autocomplete' => 'username']" />
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Senha</label>
                                <x-input name="password" type="password" :attr="['class' => 'form-control', 'autocomplete' => 'new-password']" />
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                <x-input name="password_confirmation" type="password" :attr="['class' => 'form-control', 'autocomplete' => 'new-password']" />
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
    </div>
@endsection

@section('script')
    <script src="{{ asset('build/assets/js/file.js') }}"></script>
@endsection
