<?php

namespace App\Tasks;

use Illuminate\Http\JsonResponse;

use App\Models\Task;
use App\Tasks\TaskResource;
use App\Tasks\Requests\StoreTaskRequest;
use App\Tasks\Requests\UpdateTaskRequest;

class TaskService
{
    /**
     * Returns a list of tasks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($userId)
    {
        return TaskResource::collection(Task::where('user_id', $userId)->get());
    }

    /**
     * Creates a new task.
     *
     * @param StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request, $userId)
    {
        return new TaskResource(Task::create([
            'user_id' => $userId,
            ...$request->validated()
        ]));
    }

    /**
     * Returns a specific task.
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task, $userId)
    {
        return new TaskResource(Task::where('user_id', $userId)->findOrFail($task->id));
    }

    /**
     * Updates an existing task.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task, $userId)
    {
        $task->update([
            'user_id' => $userId,
            ...$request->validated()
        ]);
        return new TaskResource($task);
    }

    /**
     * Deletes an existing task.
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task, $userId)
    {
        $task->delete([
            'user_id' => $userId,
        ]);

        return response()->noContent();
    }
}
