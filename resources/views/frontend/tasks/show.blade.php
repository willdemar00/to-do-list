@extends('frontend.app')

@section('title', 'Visualizar tarefa')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <x-breadcrumb :items="[
                    ['name' => 'Início', 'route' => route('home')],
                    ['name' => 'Tarefas', 'route' => route('tasks.index')],
                    ['name' => 'Visualizar'],
                ]" />
            </div>
            <div class="col-md-12 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Visualizar tarefa</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-body mb-3">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="form-label">Título</h5>
                            <input type="text" class="form-control" value="{{ $task->title }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="form-label">Descrição</h5>
                            <textarea class="form-control" rows="3" disabled>{{ $task->description }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <h5 class="form-label">Data</h5>
                            <input type="date" class="form-control"
                                value="{{ $task->date ? $task->date->format('Y-m-d') : '' }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <h5 class="form-label">Horário início</h5>
                            <input type="time" class="form-control"
                                value="{{ $task->start_time ? $task->start_time->format('H:i') : '' }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <h5 class="form-label">Horário final</h5>
                            <input type="time" class="form-control"
                                value="{{ $task->end_time ? $task->end_time->format('H:i') : '' }}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="form-label">Responsável</h5>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $task->user->path_image }}" alt="{{ $task->user->name }}"
                                    class="rounded-circle border-primary" width="40" height="40">
                                <input type="text" class="form-control m-0" value="{{ $task->user->name }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="form-label">Pessoas envolvidas</h5>
                            <ul class="list-group">
                                @foreach ($task->involved as $user)
                                    <li class="list-group-item d-flex align-items-center gap-2">
                                        <img src="{{ $user->path_image }}" alt="{{ $user->name }}"
                                            class="rounded-circle border-primary" width="40" height="40">
                                        <input type="text" class="form-control m-0" value="{{ $user->name }}"
                                            disabled>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
