<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BadWord\ImportRequest;
use App\Http\Requests\RequestPaginate;
use App\Http\Requests\Translate\ExportTranslate;
use App\Http\Requests\Translate\ImportTranslate;
use App\Models\Translate;
use App\Services\TranslateService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Whoops\Handler\XmlResponseHandler;

class TranslateController extends Controller
{
    /**
     * @var TranslateService
     */
    protected TranslateService $translateService;

    /**
     * @param TranslateService $translateService
     */
    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param RequestPaginate $request
     * @return JsonResponse
     */
    public function index(RequestPaginate $request): JsonResponse
    {
        return response()->json($this->translateService->getPagination($request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ImportTranslate $request
     * @return JsonResponse
     */
    public function import(ImportTranslate $request): JsonResponse
    {
        return response()->json($this->translateService->import($request));
    }

    public function export(ExportTranslate $request): bool|string
    {
        return $this->translateService->export($request);
    }
}
