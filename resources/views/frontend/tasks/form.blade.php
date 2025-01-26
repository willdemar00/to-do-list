@extends('frontend.app')

@section('title', isset($task) ? 'Editar tarefa' : 'Criar tarefa')
@section('styles')
    <style>
        .remove-user {
            border: none;
            background: transparent;
            color: var(--bs-gray);
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <x-breadcrumb :items="[
                    ['name' => 'Início', 'route' => route('home')],
                    ['name' => 'Tarefas', 'route' => route('tasks.index')],
                    ['name' => isset($task) ? 'Editar' : 'Criar'],
                ]" />
            </div>
            <div class="col-md-12 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>{{ isset($task) ? 'Editar tarefa' : 'Criar tarefa' }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body">
                        <form action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($task))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="title" class="form-label required">Título</label>
                                    <x-input name="title" type="text" :value="old('title', $task->title ?? '')" :attr="[
                                        'class' => 'form-control',
                                        'autocomplete' => 'title',
                                        'placeholder' => 'Título',
                                    ]" />
                                </div>
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Descrição</label>
                                    <x-textarea name="description" :value="old('description', $task->description ?? '')" :attr="['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Descrição']" />
                                </div>
                                <div class="col-md-4">
                                    <label for="date" class="form-label">Data</label>
                                    <x-input name="date" type="date" :value="old('date', $task->date ?? '')" :attr="[
                                        'class' => 'form-control',
                                        'autocomplete' => 'date',
                                        'placeholder' => 'Data',
                                    ]" />
                                </div>
                                <div class="col-md-4">
                                    <label for="start_time" class="form-label">Horário início</label>
                                    <x-input name="start_time" type="time" :value="old('start_time', $task->start_time ?? '')" :attr="[
                                        'class' => 'form-control',
                                        'autocomplete' => 'start_time',
                                        'placeholder' => 'Horário Início',
                                    ]" />
                                </div>
                                <div class="col-md-4">
                                    <label for="end_time" class="form-label">Horário final</label>
                                    <x-input name="end_time" type="time" :value="old('end_time', $task->end_time ?? '')" :attr="[
                                        'class' => 'form-control',
                                        'autocomplete' => 'end_time',
                                        'placeholder' => 'Horário Final',
                                    ]" />
                                </div>
                                <div class="col-md-8">
                                    <label for="responsible" class="form-label">Pessoas envolvidas</label>
                                    <x-input name="responsible" type="text" value="" :attr="[
                                        'class' => 'form-control',
                                        'autocomplete' => 'responsible',
                                        'placeholder' => 'Buscar pessoas por nome',
                                    ]" />
                                    <div id="user-list" class="list-group mt-2"></div>
                                    <!-- Adicione este div para exibir a lista de usuários -->
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Selecionados</label>
                                    <div id="selected-users" class="list-group">
                                        @if (isset($task) && !$task->involved->isEmpty())
                                            @foreach ($task->involved as $user)
                                                <div class="list-group-item d-flex justify-content-between align-items-center gap-2 selected-user"
                                                    data-user-id="{{ $user->id }}">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="{{ $user->path_image }}" alt="{{ $user->name }}"
                                                            class="rounded-circle border-primary mr-2" width="25"
                                                            height="25">
                                                        {{ $user->name }}
                                                    </div>
                                                    <button type="button" class="ml-auto remove-user"><i
                                                            class="fa-solid fa-xmark"></i></button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <!-- Adicione esta div para exibir os usuários selecionados -->
                                    <input type="hidden" name="selected_user_ids" id="selected-user-ids"
                                        value="{{ isset($task) && !$task->involved->isEmpty() ? $task->involved->pluck('id')->implode(',') : '' }}">
                                </div>
                                @if (isset($task) && isset($remove) && $remove)
                                    <div class="col-md-12 mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remove_responsible"
                                                id="remove_responsible">
                                            <label class="form-check-label" for="remove_responsible">
                                                Remover responsável
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-end mt-3 gap-2">
                                <a href="{{ route('tasks.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
                                <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function searchUsers(query) {
                if (query.length >= 3) {
                    $.ajax({
                        url: '{{ route('users.search') }}',
                        type: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            displayUserList(data);
                        }
                    });
                } else {
                    $('#user-list').empty();
                }
            }

            function displayUserList(users) {
                var userList = $('#user-list');
                userList.empty();
                if (users.length > 0) {
                    $.each(users, function(index, user) {
                        var userImage = user.image_url;
                        userList.append(
                            '<a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 user-item" data-user-id="' +
                            user.id + '" data-user-name="' + user.name + '"><img src="' + userImage +
                            '" alt="' + user.name +
                            '" class="rounded-circle border-primary mr-2" width="25" height="25">' +
                            user.name + '</a>');
                    });
                } else {
                    userList.append('<p class="list-group-item">Nenhum usuário encontrado</p>');
                }
            }

            function addUserToSelectedList(userId, userName, userImage) {
                var selectedUsers = $('#selected-users');
                selectedUsers.append(
                    '<div class="list-group-item d-flex justify-content-between align-items-center gap-2 selected-user" data-user-id="' +
                    userId + '"><div class="d-flex align-items-center gap-2"><img src="' + userImage +
                    '" alt="' + userName +
                    '" class="rounded-circle border-primary mr-2" width="25" height="25">' + userName +
                    '</div><button type="button" class="ml-auto remove-user"><i class="fa-solid fa-xmark"></i></button></div>'
                    );
                updateSelectedUserIds();
            }

            function updateSelectedUserIds() {
                var selectedUserIds = [];
                $('#selected-users .selected-user').each(function() {
                    selectedUserIds.push($(this).data('user-id'));
                });
                $('#selected-user-ids').val(selectedUserIds.join(','));
            }

            $('input[name="responsible"]').on('keyup', function() {
                var query = $(this).val();
                searchUsers(query);
            });

            $('#user-list').on('click', '.user-item', function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');
                var userImage = $(this).find('img').attr('src');
                addUserToSelectedList(userId, userName, userImage);
                $('#user-list').empty();
                $('input[name="responsible"]').val('');
            });

            $('#selected-users').on('click', '.remove-user', function() {
                $(this).closest('.selected-user').remove();
                updateSelectedUserIds();
            });
        });
    </script>
@endsection
