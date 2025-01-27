@extends('frontend.app')

@section('title', 'home')

@section('styles')
    <style>
        @media (max-width: 950px) {
            main {
                padding: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="card card-body p-4">
            <div class="col-md-12">
                <div class="header">
                    <div class="greeting">
                        <h3>Olá {{ $user->name }}!</h3>
                        <p>{{ $message }}</p>
                    </div>
                </div>

                <div class="task-card bg-primary text-white p-3">
                    <section>
                        <h3>Hoje</h3>
                        <p>Você tem {{ $tasksCount }} tarefas para fazer</p>
                    </section>
                    <div class="simple-circle">
                        <div class="percentage-text">{{ round($progress) }}%</div>
                    </div>
                </div>

                <div class="recent-activity mt-4">
                    <h4>Atividade Recente</h4>
                    <ul>
                        @foreach ($recentActivities as $activity)
                            <li>
                                <img src="{{ $activity['user_photo'] }}" alt="User Photo">
                                <div>
                                    <p>{{ $activity['description'] }}</p>
                                    <span>{{ $activity['time_ago'] }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
