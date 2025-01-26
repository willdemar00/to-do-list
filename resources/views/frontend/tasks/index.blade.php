@extends('frontend.app')

@section('title', 'Tarefas')
@section('styles')

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <x-breadcrumb :items="[['name' => 'Início', 'route' => route('home')], ['name' => 'Tarefas']]" />
        </div>
        <div class="col-md-12 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Tarefas</h3>
                <a class="btn btn-primary" href="{{ route('tasks.create') }}">Adicionar</a>
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
                <div class="row">
                    <div class="col-md-8">
                        @forelse ($tasks as $task)
                            <div class="card p-2 mb-2">
                                <div class="component-card">
                                    <div class="form-check m-0">
                                        <input class="form-check-input status" type="checkbox" value="{{ $task->id }}"
                                            id="{{ $task->id }}" {{ $task->status == 1 ? 'checked' : '' }}>
                                    </div>
                                    <label for="{{ $task->id }}" class="form-check-label text-truncate " style="cursor: pointer;">
                                        <strong class="task-title ">{{ $task->title }}</strong>
                                    </label>
                                    <div class="avatar-group">
                                        <div class="avatar-wrapper">
                                            <img src="{{ $task->user->path_image }}" alt="{{ $task->user->name }}" class="avatar">
                                            <span class="avatar-tooltip">{{ $task->user->name }}</span>
                                        </div>
                                        @foreach ($task->involved->take(4) as $user)
                                            <div class="avatar-wrapper">
                                                <img src="{{ $user->path_image }}" alt="{{ $user->name }}" class="avatar">
                                                <span class="avatar-tooltip">{{ $user->name }}</span>
                                            </div>
                                        @endforeach
                                        @if ($task->involved->count() > 4)
                                            <div class="avatar-more">+{{ $task->involved->count() - 4 }}</div>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-end align-items-start">
                                        <div class="dropdown">
                                            <button class="btn-menu dropdown-toggle" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="{{ route('tasks.show', $task->id) }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                        Visualizar
                                                    </a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('tasks.edit', $task->id) }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                        Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                                        class="delete-form">
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
                                    <div class="content">
                                        <small>
                                            <div class="d-flex flex-column">
                                                <p class="m-0 text-truncate">{{ $task->description }}</p>
                                                <span class="time">
                                                    {!! $task->formatted_time !!}
                                                </span>
                                            </div>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="card p-2 mb-2">
                                Nenhuma tarefa encontrada.
                            </div>
                        @endforelse
                    </div>
                    <div class="col-md-4">
                        <div class="card p-2">
                            teste
                        </div>
                    </div>
                </div>
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
                    Tem certeza que deseja excluir esta tarefa?
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
            $('.status').on('change', function() {
                var componentCard = $(this).closest('.component-card');
                var taskTitle = componentCard.find('.task-title');
                if ($(this).is(':checked')) {
                    componentCard.css('opacity', '0.4');
                    taskTitle.css('text-decoration', 'line-through');
                } else {
                    componentCard.css('opacity', '1');
                    taskTitle.css('text-decoration', 'none');
                }
            });

            // Aplicar opacidade inicial e tachado com base no status da caixa de seleção
            $('.status').each(function() {
                var componentCard = $(this).closest('.component-card');
                var taskTitle = componentCard.find('.task-title');
                if ($(this).is(':checked')) {
                    componentCard.css('opacity', '0.4');
                    taskTitle.css('text-decoration', 'line-through');
                }
            });

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
