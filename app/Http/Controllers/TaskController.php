<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $tasks = Auth::user()->tasks()->all();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
        ]);
        $task = new Task();
        $task->body = $request->get('body');
        $task->user_id = Auth::id();
        $task->save();

        return response()->json($task);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @param                  $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task, $taskId)
    {
        $Task = $task->findOrFail($taskId);
        if (!Auth::user()->tasks->contains($taskId)) {
            return response()->json('Not your task', 203);
        }
        return $Task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task, $taskId)
    {
        $Task = $task->findOrFail($taskId);
        if (!Auth::user()->tasks->contains($taskId)) {
            return response()->json('Not your task', 203);
        }
        $request->validate([
            'body' => 'required',
            'completed' => 'boolean'
        ]);
        $task = new Task();
        $task->body = $request->get('body');
        $task->completed = $request->get('completed');
        $task->save();

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Task $task
     * @param                  $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task, $taskId)
    {
        $Task = $task->findOrFail($taskId);
        if (!Auth::user()->tasks->contains($taskId)) {
            return response()->json('Not your task', 203);
        }
        $Task->delete();
    }
}
