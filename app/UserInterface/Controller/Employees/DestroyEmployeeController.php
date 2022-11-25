<?php

namespace App\UserInterface\Controller\Employees;

use App\Application\Employees\DestroyEmployeeUseCase;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

class DestroyEmployeeController extends Controller
{

    private DestroyEmployeeUseCase $destroyEmployeeUseCase;

    public function __construct(DestroyEmployeeUseCase $destroyEmployeeUseCase) {
        $this->destroyEmployeeUseCase = $destroyEmployeeUseCase;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $id): JsonResponse
    {
        $this->destroyEmployeeUseCase->__invoke($id);

        return Response::json([], JsonResponse::HTTP_NO_CONTENT);
    }
}
