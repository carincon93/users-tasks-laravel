<?php

namespace App\Tasks;

use Illuminate\Http\JsonResponse;

use App\Models\Task;
use App\Tasks\TaskResource;
use App\Tasks\Requests\StoreTaskRequest;
use App\Tasks\Requests\UpdateTaskRequest;
use App\Tasks\Requests\IndexTaskRequest;

class TaskService
{
    /**
     * Returns a list of tasks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexTaskRequest $request, $userId)
    {
        $tasks = Task::where('user_id', $userId);
        $count = $tasks->count();

        if ($request->is_completed !== null) {
            $tasks->where('completed', $request->is_completed);
        }

        if ($request->title !== null) {
            $tasks->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->description !== null) {
            $tasks->where('description', 'like', '%' . $request->description . '%');
        }

        if ($request->limit !== null && $request->limit > 0) {
            $tasks->limit($request->limit);
        }

        if ($request->offset !== null && $request->offset > 0) {
            $tasks->offset($request->offset);
        }

        return [
            'data' => TaskResource::collection($tasks->orderBy('id', 'asc')->get()),
            'count' => $count,
        ];
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
