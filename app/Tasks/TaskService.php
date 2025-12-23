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
    public function index()
    {
        return TaskResource::collection(Task::all());
    }

    /**
     * Creates a new task.
     *
     * @param StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        return new TaskResource(Task::create($request->validated()));
    }

    /**
     * Updates an existing task.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return new TaskResource($task);
    }

    /**
     * Deletes an existing task.
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
