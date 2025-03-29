<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        return view('todo');
    }

    public function fetchTasks()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tasks,name|max:255',
        ]);

        $task = Task::create(['name' => $request->name]);
        return response()->json($task);
    }

    public function updateStatus($id)
    {
        $task = Task::findOrFail($id);
        $task->update(['completed' => !$task->completed]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
