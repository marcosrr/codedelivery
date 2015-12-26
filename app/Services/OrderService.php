<?php

namespace CodeDelivery\Services;

use CodeDelivery\Repositories\OrderRepository;

class OrderService
{
	
	private $orderRepository;

	public function __construct(OrderRepository $orderRepository)
	{
		$this->orderRepository = $orderRepository;
	}

	public function listStatus()
	{
		$list_status = [
			0=>'Pendente', 
			1=>'A caminho', 
			2=>'Entregue'
		];
		return $list_status;
	}
}