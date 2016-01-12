<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Support\Facades\Auth; //ou só: use Auth;

class CheckoutController extends Controller
{

    private $orderRepository;
    private $userRepository;
    private $productRepository;
    private $orderService;
    private $clientId;

    public function __construct( 
        OrderRepository $orderRepository,  
        UserRepository $userRepository,  
        ProductRepository $productRepository,
        OrderService $orderService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
        $this->clientId = (Auth::check()) ? $this->userRepository->find(Auth::user()->id)->client->id : null;
    }

    public function index()
    {
        $orders = $this->orderRepository->buscarOrdensPorCliente($this->clientId);

        return view('customer.order.index', compact('orders'));
    }

    public function create()
    {
        $products = $this->productRepository->lists();
        return view('customer.order.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['client_id'] = $this->clientId;
        $this->orderService->create($data);

        return redirect()->route('customer.order.index');
    }
    
}
