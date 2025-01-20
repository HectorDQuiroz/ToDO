<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Auth::user()->tasks()->orderBy('priority', 'desc');
    
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('description', 'LIKE', '%' . $searchTerm . '%');
        }
    
        $tasks = $query->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $priorities = ['baja', 'media', 'alta'];
        return view('tasks.create', compact('priorities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:255',
            'priority'    => 'required|in:baja,media,alta',
            'tags'        => 'nullable|array',
            'notes'       => 'nullable|string', // Agrega validación para notes
        ]);
    
        $task = Auth::user()->tasks()->create([
            'description' => $request->description,
            'priority'    => $request->priority,
            'notes'       => $request->notes, // Guarda las notas
        ]);
    
        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente.');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $priorities = ['baja', 'media', 'alta'];
        return view('tasks.edit', compact('task', 'priorities'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'description' => 'required|max:255',
            'priority'    => 'required|in:baja,media,alta',
            'tags'        => 'nullable|array',
            'notes'       => 'nullable|string', // Agrega validación para notes
        ]);
    
        $task->update([
            'description' => $request->description,
            'priority'    => $request->priority,
            'notes'       => $request->notes, // Actualiza las notas
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada exitosamente.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente.');
    }

    public function complete(Task $task)
    {
        $this->authorize('update', $task);

        $task->completed = !$task->completed;
        $task->save();

        return back();
    }
}