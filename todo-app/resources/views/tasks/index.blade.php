@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h1 class="mb-4">Mis Tareas</h1>

            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">Nueva Tarea</a>
                <form action="{{ route('tasks.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Buscar tarea..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary">Buscar</button>
                </form>
            </div>

            <ul class="list-group">
                @foreach ($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="{{ $task->completed ? 'text-decoration-line-through' : '' }}">
                        {{ $task->description }}
                    </span>
                    <div class="d-flex align-items-center">

                        <span class="badge badge-pill ms-2
                            @if ($task->priority == 'baja') badge bg-secondary
                            @elseif ($task->priority == 'media') badge bg-primary
                            @else badge bg-warning @endif
                        "> PRIORIDAD - 
                            {{ strtoupper($task->priority) }} 
                        </span>
                        <div class="ms-2">
                            @if ($task->tags)
                            @foreach ($task->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        @endif
                        </div>
                    </div>

                    <div class="btn-group">
                        <div>
                            <form action="{{ route('tasks.complete', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm me-2 {{ $task->completed ? 'btn-warning' : 'btn-success' }}">
                                    {{ $task->completed ? 'Pendiente' : 'Completar' }}
                                </button>
                            </form>
                        </div>
                        <div>
                            <a href="{{ route('tasks.edit', ['task' => $task->id]) }}" class="btn btn-sm btn-secondary me-2">Editar</a>
                        </div>
                        <div>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                    @if ($task->notes)
                    <div class="mt-2">
                        <small>{{ $task->notes }}</small>
                    </div>
                @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection