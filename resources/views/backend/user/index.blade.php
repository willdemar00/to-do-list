@extends('frontend.app')

@section('title', 'Usuários')

@section('styles')
    <style>
        .pagination-input {
            width: 36px !important;
            padding: 3px !important;
            height: 36px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-breadcrumb :items="[['name' => 'Início', 'route' => route('home')], ['name' => 'Perfil']]" />
        </div>
        <div class="col-md-12 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Usuários</h3>
                <a class="btn btn-primary" href="{{ route('user.create') }}">Adicionar</a>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-body">
                <form action="{{ route('user.index') }}" method="GET" class="form-inline">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="name" class="form-control" placeholder="Nome do Usuário"
                                value="{{ request('name') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="email" class="form-control" placeholder="Email do Usuário"
                                value="{{ request('email') }}">
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
                                <a class="btn btn-sm btn-secondary" href="{{ route('user.index') }}">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <div class="d-flex align-items-center gap-1" style="font-size: .9em">
                                <input class="form-control m-0 pagination-input"
                                    value="{{ !empty(request()->get('pagination')) ? request()->get('pagination') : '15' }}"
                                    name="pagination" type="text">
                                <span>itens por página</span>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Email</th>
                                <th></th> <!-- Ações -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center gap-1">
                                            <img src="{{ $user->PathImage }}" alt="{{ $user->name }}"
                                                class="rounded-circle border-primary" width="40" height="40">
                                            <span class="ms-2">{{ $user->name }}</span>
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Ações
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.show', $user->id) }}">
                                                            <i class="fa-regular fa-eye"></i>
                                                            Visualizar
                                                        </a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.edit', $user->id) }}">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                             Editar
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('user.destroy', $user->id) }}"
                                                            method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal"
                                                                class="dropdown-item delete-button">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                                Excluir
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                {{ $users->links('custom.pagination') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este usuário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger confirm-delete">Excluir</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let deleteButton;
            $('.delete-button').on('click', function() {
                deleteButton = $(this);
            });

            $('.confirm-delete').on('click', function() {
                deleteButton.attr('type', 'submit');
                deleteButton.closest('form').submit();
            });
        });
    </script>
@endsection
