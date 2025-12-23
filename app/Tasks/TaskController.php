<?php

namespace App\Tasks;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Tasks\Requests\StoreTaskRequest;
use App\Tasks\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Tasks\TaskService;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    public $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /** 
     * 
     * Returns a list of tasks.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth();

        $authUserId = $guard->user()->id;

        return response()->json(
            [
                'status' => 'success',
                'data' => $this->taskService->index($authUserId)
            ]
        );
    }

    /** 
     * 
     * Creates a new task.
     * 
     * @param StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth();

        $authUserId = $guard->user()->id;

        return response()->json(
            [
                'status' => 'success',
                'data' => $this->taskService->store($request, $authUserId)
            ]
        );
    }

    /** 
     * 
     * Returns a specific task.
     * 
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth();

        $authUserId = $guard->user()->id;

        return response()->json(
            [
                'status' => 'success',
                'data' => $this->taskService->show($task, $authUserId)
            ]
        );
    }

    /** 
     * 
     * Updates an existing task.
     * 
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth();

        $authUserId = $guard->user()->id;

        return response()->json(
            [
                'status' => 'success',
                'data' => $this->taskService->update($request, $task, $authUserId)
            ]
        );
    }

    /** 
     * 
     * Deletes an existing task.
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task): JsonResponse
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth();

        $authUserId = $guard->user()->id;

        return response()->json(
            [
                'status' => 'success',
                'data' => $this->taskService->destroy($task, $authUserId)
            ]
        );
    }
}
