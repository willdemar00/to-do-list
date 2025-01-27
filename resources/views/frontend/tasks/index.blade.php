@extends('frontend.app')

@section('title', 'Tarefas')
@section('styles')
    <style>
        .list-group {
            position: absolute;
            width: 23%;
            z-index: 9;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <x-breadcrumb :items="[['name' => 'Início', 'route' => route('home')], ['name' => 'Tarefas']]" />
        </div>
        <div class="col-md-12 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Tarefas</h3>
                <a class="btn btn-sm btn-primary" href="{{ route('tasks.create') }}">Adicionar</a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card card-body">
                <form id="task-search-form" action="{{ route('tasks.index') }}" method="GET" class="form-inline">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="title" class="form-control" placeholder="Nome da tarefa"
                                value="{{ !empty(request()->get('title')) ? request()->get('title') : '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request()->get('start_date') }}">

                        </div>
                        <div class="col-md-3">
                            <input type="text" id="user-search" class="form-control" placeholder="Buscar usuários">
                            <div id="user-results" class="mt-2 list-group"></div>
                            <input type="hidden" name="selected_user_ids" id="selected_user_ids"
                                value="{{ request()->get('selected_user_ids') }}">
                        </div>
                        <div class="col-md-2">
                            <div id="selected-users" class="mt-2 d-flex flex-wrap gap-2">
                                @if (request()->filled('selected_user_ids'))
                                    @foreach (explode(',', request()->get('selected_user_ids')) as $userId)
                                        @php
                                            $user = \App\Models\User::find($userId);
                                        @endphp
                                        @if ($user)
                                            <div class="badge bg-primary selected-user" data-id="{{ $user->id }}">
                                                {{ $user->name }} <span class="remove-user"
                                                    style="cursor:pointer;">&times;</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
                                @if (!empty(request()->all()))
                                    <a class="btn btn-sm btn-secondary" href="{{ route('tasks.index') }}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                @endif

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
                                            id="{{ $task->id }}"
                                            {{ $task->status == App\Models\Tasks::STATUS_COMPLETED ? 'checked' : '' }}>
                                    </div>
                                    <label for="{{ $task->id }}" class="form-check-label text-truncate "
                                        style="cursor: pointer;">
                                        <strong class="task-title ">{{ $task->title }}</strong>
                                    </label>
                                    <div class="avatar-group">
                                        <div class="avatar-wrapper">
                                            <img src="{{ $task->user->path_image }}" alt="{{ $task->user->name }}"
                                                class="avatar">
                                            <span class="avatar-tooltip">{{ $task->user->name }}</span>
                                        </div>
                                        @foreach ($task->involved->take(4) as $user)
                                            <div class="avatar-wrapper">
                                                <img src="{{ $user->path_image }}" alt="{{ $user->name }}"
                                                    class="avatar">
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
                            <h4 class="text-center">{{ \Carbon\Carbon::now()->locale('pt_BR')->translatedFormat('F Y') }}
                            </h4>
                            <div class="container-week-selector">
                                <div class="d-flex justify-content-between w-75">
                                    @php
                                        $daysOfWeek = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                                        $currentDay = \Carbon\Carbon::now()->day;
                                        $currentWeekDay = \Carbon\Carbon::now()->dayOfWeek;
                                        $selectedDate =
                                            request()->get('start_date') ?? \Carbon\Carbon::now()->toDateString();
                                    @endphp
                                    @for ($i = 0; $i < 7; $i++)
                                        @php
                                            $date = \Carbon\Carbon::now()->startOfWeek()->addDays($i);
                                            $isSelected = $selectedDate == $date->toDateString();
                                        @endphp
                                        <div class="text-center day-selector {{ $isSelected ? 'bg-primary text-white' : '' }}"
                                            data-date="{{ $date->toDateString() }}">
                                            {{ $daysOfWeek[$i] }}<br>{{ $date->day }}
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <strong>{{ $scheduledTasks->count() }} Compromissos Hoje</strong>
                            </div>
                            <h6 class="mt-2">Tarefas agendadas</h6>
                            <div class="timeline mt-1">
                                @forelse ($scheduledTasks as $scheduled)
                                    <div class="timeline-item  mb-1">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <p class="time">
                                                {{ $scheduled->start_time ? $scheduled->start_time->format('H:i') : $scheduled->created_at->format('H:i') }}
                                            </p>
                                            <h5 class="text-truncate">{{ $scheduled->title }}</h5>
                                            <p class="text-truncate">{{ $scheduled->description }}</p>
                                            <div class="avatar-group p-2">
                                                @foreach ($scheduled->involved as $user)
                                                    <img src="{{ $user->path_image }}" alt="{{ $user->name }}"
                                                        class="avatar">
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="px-2">Nenhum compromisso agendado para hoje.</p>
                                @endforelse
                            </div>
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
                var taskId = $(this).val();
                var status = $(this).is(':checked') ? '{{ App\Models\Tasks::STATUS_COMPLETED }}' :
                    '{{ App\Models\Tasks::STATUS_PENDING }}';

                $.ajax({
                    url: '{{ route('tasks.updateStatus') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: taskId,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            if (status === '{{ App\Models\Tasks::STATUS_COMPLETED }}') {
                                componentCard.addClass('opacity-40');
                                taskTitle.css('text-decoration', 'line-through');
                            } else {
                                componentCard.removeClass('opacity-40');
                                taskTitle.css('text-decoration', 'none');
                            }
                        } else {
                            alert('Ocorreu um erro ao atualizar o status da tarefa.');
                        }
                    },
                    error: function() {
                        alert('Ocorreu um erro ao atualizar o status da tarefa.');
                    }
                });
            });

            // Aplicar opacidade inicial e tachado com base no status da caixa de seleção
            $('.status').each(function() {
                var componentCard = $(this).closest('.component-card');
                var taskTitle = componentCard.find('.task-title');
                if ($(this).is(':checked')) {
                    componentCard.addClass('opacity-40');
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

            $('#user-search').on('input', function() {
                var query = $(this).val();
                if (query.length > 2) {
                    $.ajax({
                        url: '{{ route('users.search') }}',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            var results = $('#user-results');
                            results.empty();
                            response.forEach(function(user) {
                                results.append(
                                    '<div class="list-group-item list-group-item-action user-result" data-id="' +
                                    user.id + '">' + user.name + '</div>');
                            });
                        }
                    });
                }
            });

            $('#user-search').on('blur', function() {
                setTimeout(function() {
                    $('#user-results').empty();
                }, 200);
            });

            $(document).on('click', '.user-result', function() {
                var userId = $(this).data('id');
                var userName = $(this).text();
                var selectedUsers = $('#selected-users');
                var selectedUserIds = $('#selected_user_ids').val().split(',').filter(Boolean);

                if (!selectedUserIds.includes(userId.toString())) {
                    selectedUsers.append('<div class="badge bg-primary selected-user" data-id="' + userId +
                        '">' + userName +
                        ' <span class="remove-user" style="cursor:pointer;">&times;</span></div>');
                    selectedUserIds.push(userId);
                    $('#selected_user_ids').val(selectedUserIds.join(','));
                    $('#user-search').val('');
                    $('#user-results').empty();
                }
            });

            $(document).on('click', '.remove-user', function() {
                var userDiv = $(this).parent();
                var userId = userDiv.data('id');
                var selectedUserIds = $('#selected_user_ids').val().split(',');

                selectedUserIds = selectedUserIds.filter(function(id) {
                    return id != userId;
                });

                $('#selected_user_ids').val(selectedUserIds.join(','));
                userDiv.remove();
            });

            $('.day-selector').on('click', function() {
                var selectedDate = $(this).data('date');
                $('#start_date').val(selectedDate);
                $('#task-search-form').submit();
            });
        });
    </script>
@endsection
