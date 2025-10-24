<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display the dashboard view with tasks.
     */
    public function index()
    {
        $tasks = Task::with('subtasks')->get()->groupBy('priority_level')->sortByDesc('created_at');
        return view('manageTasks', compact('tasks'));
    }

    /**
     * Get all tasks with subtasks for Ajax updates.
     */
    public function getTasks()
    {
        return response()->json(Task::with('subtasks')->get());
    }

    /**
     * Store a new task.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority_level' => 'required|in:critical,high,medium,low',
            'subtasks.*.text' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority_level' => $request->priority_level,
        ]);

        if ($request->has('subtasks')) {
            foreach ($request->subtasks as $subtask) {
                if (!empty($subtask['text'])) {
                    $task->subtasks()->create([
                        'subtask_text' => $subtask['text'],
                        'is_completed' => false,
                    ]);
                }
            }
        }

        return response()->json($task->load('subtasks'), 201);
    }

    /**
     * Show a specific task with subtasks.
     */
    public function show($id)
    {
        $task = Task::with('subtasks')->findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update a task and its subtasks.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority_level' => 'required|in:critical,high,medium,low',
            'subtasks.*.id' => 'nullable|integer|exists:subtasks,id',
            'subtasks.*.text' => 'required|string|max:255',
            'subtasks.*.completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority_level' => $request->priority_level,
        ]);

        $subtaskIds = [];

        if ($request->has('subtasks')) {
            foreach ($request->subtasks as $sub) {
                $completed = isset($sub['completed']) ? (bool) $sub['completed'] : false;

                if (isset($sub['id']) && $sub['id']) {
                    $subtask = $task->subtasks()->find($sub['id']);
                    if ($subtask) {
                        $subtask->update([
                            'subtask_text' => $sub['text'],
                            'is_completed' => $completed,
                        ]);
                        $subtaskIds[] = $sub['id'];
                    }
                } else {
                    $newSubtask = $task->subtasks()->create([
                        'subtask_text' => $sub['text'],
                        'is_completed' => $completed,
                    ]);
                    $subtaskIds[] = $newSubtask->id;
                }
            }
        }

        // Delete removed subtasks
        $task->subtasks()->whereNotIn('id', $subtaskIds)->delete();

        return response()->json($task->fresh()->load('subtasks'));
    }

    /**
     * Delete a task and its subtasks.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->subtasks()->delete();
        $task->delete();
        return response()->json(['success' => true]);
    }
};
