<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
  
    public function index()
    {
        // Simple direct queries like a student would write
        $tasks = Task::orderBy('created_at', 'desc')->get();
        $total = Task::count();
        $pending = Task::where('status', 'Pending')->count();
        $completed = Task::where('status', 'Completed')->count();

        return view('index', compact('tasks', 'total', 'pending', 'completed'));
    }


    public function create()
    {
        return view('create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }


    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('edit', compact('task'));
    }

    // Update task details
    public function update(Request $request, $id)
    {
        $request->validate([
            'task_name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    // Toggle status quickly from dashboard (Pending <-> Completed)
    public function toggleStatus($id)
    {
        $task = Task::findOrFail($id);
        if ($task->status == 'Pending') {
            $task->status = 'Completed';
        } else {
            $task->status = 'Pending';
        }
        $task->save();

        return redirect()->back()->with('success', 'Task status updated!');
    }

 
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}