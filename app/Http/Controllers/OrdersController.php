<?php

namespace App\Http\Controllers;

use App\Domain\Repositories\MealsRepository;
use App\Domain\Repositories\OrderDetailsRepository;
use App\Domain\Repositories\OrdersRepository;
use App\Domain\Repositories\ReservationsRepository;
use App\Http\Requests\StoreOrdersRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{

    /**
     * @var OrdersRepository
     */
    private OrdersRepository $orderRepository;
    /**
     * @var OrderDetailsRepository
     */
    private OrderDetailsRepository $orderDetailsRepository;
    private ReservationsRepository $reservationRepository;
    private MealsRepository $mealsRepository;

    /**
     * @param OrdersRepository $orderRepository
     * @param OrderDetailsRepository $orderDetailsRepository
     */
    public function __construct(OrdersRepository $orderRepository , OrderDetailsRepository $orderDetailsRepository , ReservationsRepository $reservationRepository , MealsRepository $meals)
    {
        $this->orderRepository = $orderRepository;
        $this->orderDetailsRepository = $orderDetailsRepository;
        $this->reservationRepository = $reservationRepository;
        $this->mealsRepository = $meals;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->orderRepository->getAll()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(StoreOrdersRequest $request): JsonResponse
    {



        DB::beginTransaction();
        try {
            $data = $request->validated();
            $orderDetails = $request->only([
                'reservation_id',
                'waiter_id'


            ]);

            //check total price according to meals price and discounts
            $orderPrices = $this->mealsRepository->getMealsTotal($data['meals']);
            $orderDetails['total'] = ceil($orderPrices['totalPrice']);
            $orderDetails['paid'] = ceil($orderPrices['totalPrice'] - $orderPrices['totalDiscount']) ;


            $orderInsert = $this->orderRepository->create($orderDetails);
            if(isset($orderInsert->id)){
                foreach ($data['meals'] as $meal){
                    //check if meal is available
                   $meal_av_qty = $this->mealsRepository->getById($meal['meal_id']);
                   if($meal_av_qty->av_qty > $meal['amount']){
                       //add order details
                       $this->orderDetailsRepository->create(['order_id' => $orderInsert->id , 'meal_id' => $meal['meal_id'] , 'amount' => $meal['amount'] ]);
                       // update meals Average amount

                       $this->mealsRepository->getById($meal['meal_id'])->decrement('av_qty',$meal['amount']);
                   }


                }

                //then update reservation by disable
                $this->reservationRepository->update($orderDetails['reservation_id'] , ['ordered' => 1 , 'waiting_list' => 0]);

                DB::commit();
                $results = $orderInsert;
                $status = Response::HTTP_CREATED;
            }

        }catch (\Exception $exception){
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
        $orderId = $request->all('id');

        return response()->json([
            'data' => $this->orderRepository->getById($orderId)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $data =  $request->all();
        $orderId =$data['id'];

        return response()->json([
            'data' => $this->orderRepository->update($orderId, $data)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $orderId = $request->route('id');
        $this->orderRepository->delete($orderId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

}
