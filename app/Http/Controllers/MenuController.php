<?php

namespace App\Http\Controllers;

use App\Domain\Repositories\MealsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class MenuController extends Controller
{
    /**
     * @var MealsRepository
     */
    private MealsRepository $mealsRepository;

    /**
     * @param MealsRepository $mealsRepository
     */
    public function __construct(MealsRepository $mealsRepository)
    {
        $this->mealsRepository = $mealsRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->mealsRepository->getAll()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $mealDetails = $request->only([
            'description',
            'av_qty',
            'price',
            'discount',
        ]);

        return response()->json(
            [
                'data' => $this->mealsRepository->create($mealDetails)
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $mealId = $request->all('id');

        return response()->json([
            'data' => $this->mealsRepository->getById($mealId)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $mealId = $request->all('id');
        $mealDetails = $request->only([
            'description',
            'av_qty',
            'price',
            'discount',
        ]);

        return response()->json([
            'data' => $this->mealsRepository->update($mealId, $mealDetails)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $mealId = $request->all('id');;
        $this->mealsRepository->delete($mealId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
