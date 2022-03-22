<?php

namespace App\Http\Controllers;

use App\Domain\Repositories\ReservationsRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreReservationRequest ;

class ReservationsController extends Controller
{

    /**
     * @var ReservationsRepository
     */
    private ReservationsRepository $reservationRepository;

    /**
     * @param ReservationsRepository $reservationRepository
     */
    public function __construct(ReservationsRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->reservationRepository->getAll()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(StoreReservationRequest $request): JsonResponse
    {

        DB::beginTransaction();
        try {
            //check date
            $reservationDetails = $request->validated();
            //check if table is available for reservation
            $checkReservation =$this->reservationRepository->checkAvailability($reservationDetails);
            // if table is Reserved Customer is waiting list
            if(isset($checkReservation->id)) $reservationDetails['waiting_list'] = 1;
            $reservationDetails['from_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $reservationDetails['from_time']);
            $reservationDetails['from_time'] = Carbon::createFromFormat('Y-m-d H:i:s',  $reservationDetails['from_time']);

          $results =   $this->reservationRepository->create($reservationDetails);
          $status = Response::HTTP_CREATED;
            DB::commit();

        }catch(\Exception $exception){
            DB::rollBack();
            $results = $exception->getMessage() . ' '.$exception->getFile() . ' ' .$exception->getLine();
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json(
            [
                'data' => $results ?? []
            ],
            $status ?? Response::HTTP_NO_CONTENT
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $reservationId = $request->all('id');;

        return response()->json([
            'data' => $this->reservationRepository->getById($reservationId)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $reservationId = $request->all('id');
        $reservationDetails = $request->only([
            'from_time',
            'to_time',
            'customer_id',
            'table_id'
        ]);

        return response()->json([
            'data' => $this->reservationRepository->update($reservationId, $reservationDetails)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $reservationId = $request->all('id');
        $this->reservationRepository->delete($reservationId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


}
