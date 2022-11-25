<?php

namespace App\UserInterface\Controller\Employees;

use App\Application\Employees\IndexEmployeeUseCase;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

class IndexEmployeeController extends Controller
{
    private IndexEmployeeUseCase $indexEmployeeUseCase;

    public function __construct(IndexEmployeeUseCase $indexEmployeeUseCase) {
        $this->indexEmployeeUseCase = $indexEmployeeUseCase;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $users = $this->indexEmployeeUseCase->__invoke(
            (int) $request->query('offset'),
            $request->query('first_name'),
            $request->query('last_name'),
            $request->query('department'),
            $request->query('has_access'),
            $request->query('date_init'),
            $request->query('date_end'),
        );

        return Response::json([
            'data' => $users
        ], JsonResponse::HTTP_OK);
    }
}
