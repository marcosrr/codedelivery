<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer; //ou só: use Authorizer;

class DeliverymanCheckoutController extends Controller
{

    private $orderRepository;
    private $userRepository;
    private $orderService;

    public function __construct( 
        OrderRepository $orderRepository,  
        UserRepository $userRepository,  
        OrderService $orderService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $orders = $this->orderRepository->buscarOrdensPorDeliveryman($idDeliveryman);
        return $orders;
    }

    public function show($idOrder)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->orderRepository->buscarOrdensPorIdEDeliveryman($idOrder, $idDeliveryman);
        return $order;
    }

    public function updateStatus(Request $request, $id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->orderService->updateStatus($id, $idDeliveryman, $request->get('status'));
        if($order){
            return $order;
        }
        abort(400, 'Order não encontrada');

    }
}
