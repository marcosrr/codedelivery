<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer; //ou só: use Authorizer;

class ClientCheckoutController extends Controller
{

    private $orderRepository;
    private $userRepository;
    private $orderService;
    private $clientId;

    public function __construct( 
        OrderRepository $orderRepository,  
        UserRepository $userRepository,  
        OrderService $orderService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
        //$this->clientId = (Authorizer::getResourceOwnerId()) ? $this->userRepository->find(Authorizer::getResourceOwnerId())->client->id : null;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $this->clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->orderRepository->buscarOrdensPorCliente($this->clientId);
        return $orders;
    }

    public function show($id)
    {
        $order = $this->orderRepository->with(['client','items.product','cupom'])->find($id);
        /*$order->items->each(function($item){
            $item->product;
        });*/
        return $order;
    }

    public function store(Request $request)
    {

        $id = Authorizer::getResourceOwnerId();
        $this->clientId = $this->userRepository->find($id)->client->id;
        $data = $request->all();
        $data['client_id'] = $this->clientId;
        $order = $this->orderService->create($data); //grava e recupera o objeto inserido
        $order = $this->orderRepository->with('items')->find($order->id); //utiliza o objeto inserido para buscar os seus items
        return $order;
    }
    
}
