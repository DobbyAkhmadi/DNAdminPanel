<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BadWord\ImportRequest;
use App\Http\Requests\RequestPaginate;
use App\Services\BadWordService;
use Illuminate\Http\JsonResponse;

class BadWordController extends Controller
{
    /**
     * @var BadWordService
     */
    protected BadWordService $badWordService;

    /**
     * @param BadWordService $badWordService
     */
    public function __construct(BadWordService $badWordService)
    {
        $this->badWordService = $badWordService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param RequestPaginate $request
     * @return JsonResponse
     */
    public function index(RequestPaginate $request): JsonResponse
    {
        return response()->json($this->badWordService->getPagination($request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function import(ImportRequest $request): JsonResponse
    {
        return response()->json($this->badWordService->import($request));
    }
}
