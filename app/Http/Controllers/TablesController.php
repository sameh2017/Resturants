<?php

namespace App\Http\Controllers;

use App\Domain\Repositories\ReservationsRepository;
use App\Domain\Repositories\TablesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;



class TablesController extends Controller
{
    /**
     * @var TablesRepository
     */
    private TablesRepository $tablesRepository;
    /**
     * @var ReservationsRepository
     */
    private ReservationsRepository $reserveRepository;


    /**
     * @param TablesRepository $tablesRepository
     * @param ReservationsRepository $reserveRepository
     */
    public function __construct(TablesRepository $tablesRepository , ReservationsRepository $reserveRepository)
    {
        $this->tablesRepository = $tablesRepository;
        $this->reserveRepository = $reserveRepository;
    }


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->tablesRepository->getAll()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $orderDetails = $request->only([
            'capacity' ,

        ]);

        return response()->json(
            [
                'data' => $this->tablesRepository->create($orderDetails)
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
        $tableId = $request->route('id');

        return response()->json([
            'data' => $this->tablesRepository->getById($tableId)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $tablesDetails = $request->only([
            'table_id' ,
            'capacity'
        ]);

        return response()->json([
            'data' => $this->tablesRepository->update($tablesDetails['table_id'], $tablesDetails)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $tableId = $request->route('id');
        $this->tablesRepository->delete($tableId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkAvailability(Request $request): JsonResponse
    {
         //todo Validation Request
        $orderDetails = $request->only([
            'from_time' ,
            'to_time' ,
            'no_gust'
        ]);

        $tables =  $this->tablesRepository->getAvailableTables($orderDetails);
        if(isset($tables)){
            $orderDetails['table_id'] = $tables->id;
            //to be removed
//            $checkReservation =$this->reserveRepository->checkAvailability($orderDetails);
//dd($checkReservation);
            $waitingList = $this->reserveRepository->getWaitingLIst($orderDetails);
            if($waitingList > 0){
                //$waitingList = $this->reserveRepository->getWaitingLIst($orderDetails);
                //todo Localize Message
                $message = 'This Tables Will Be Available after ' .$orderDetails['to_time'] . ' And Has  ' . $waitingList . ' Waiting List';

            }else{

                //todo Localize Message
                $message = 'This Tables is Available Now' ;

            }

        }else{
            //todo Localize Message
            $message = ' Tables is Not Found' ;
        }
        return response()->json(['success' => true ,'message' => $message], Response::HTTP_OK);

    }

}
