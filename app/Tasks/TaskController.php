<?php

namespace App\Tasks;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Support\Pagination;
use App\Tasks\Requests\StoreTaskRequest;
use App\Tasks\Requests\UpdateTaskRequest;
use App\Tasks\Requests\IndexTaskRequest;
use App\Tasks\TaskService;
use App\Models\Task;

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
    public function index(IndexTaskRequest $request): JsonResponse
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth();

        $authUserId = $guard->user()->id;

        $tasks = $this->taskService->index($request, $authUserId);
        $count = $tasks['count'];
        $apiPrefix = config('app.api_url') . ":" . config('app.api_port') . "/api" . config('app.api_prefix');
        $pagination = Pagination::make($request->offset, $request->limit, $count);

        return response()->json(
            [
                'count' => $count,
                'next' => $pagination['next'] ? $apiPrefix . "/tasks?offset=" . $pagination['next']['offset'] . "&limit=" . $request->limit : null,
                'previous' => $pagination['previous'] ? $apiPrefix . "/tasks?offset=" . $pagination['previous']['offset'] . "&limit=" . $request->limit : null,
                'results' => $tasks['data'],
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
                'result' => $this->taskService->store($request, $authUserId)
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
                'result' => $this->taskService->show($task, $authUserId)
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
                'result' => $this->taskService->update($request, $task, $authUserId)
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
                'result' => $this->taskService->destroy($task, $authUserId)
            ]
        );
    }
}
