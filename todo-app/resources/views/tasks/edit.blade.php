@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Editar Tarea</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" name="description" id="description" class="form-control form-control-lg @error('description') is-invalid @enderror" value="{{ old('description', $task->description) }}" required placeholder="Escribe aquí la descripción de la tarea">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas (opcional)</label>
                            <textarea name="notes" id="notes" class="form-control form-control-lg" placeholder="Escribe aquí notas adicionales o una descripción detallada de la tarea">{{ old('notes', $task->notes) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="priority">Prioridad</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="baja" {{ old('priority', $task->priority) == 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('priority', $task->priority) == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('priority', $task->priority) == 'alta' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Actualizar</button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection