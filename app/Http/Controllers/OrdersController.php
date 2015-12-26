<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;

class OrdersController extends Controller
{

	private $repository;
    private $orderService;
    private $userRepository;

    public function __construct(OrderRepository $repository, OrderService $orderService, UserRepository $userRepository)
    {
    	$this->repository = $repository;
        $this->orderService = $orderService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
    	$orders = $this->repository->paginate();

    	return view('admin.orders.index', compact('orders'));
    }

    public function edit($id)
    {

        $list_status = $this->orderService->listStatus();
        $list_deliveryman = $this->userRepository->listDeliveryman();

        $order = $this->repository->find($id);

        return view('admin.orders.edit', compact('order', 'list_status', 'list_deliveryman'));
    }

    public function update(Request $request, $id)
    {
        $all = $request->all();
        $order = $this->repository->update($all, $id);

        return redirect()->route('admin.orders.index');
    }
}
