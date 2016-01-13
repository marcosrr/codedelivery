<?php

namespace CodeDelivery\Services;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Models\Order;

class OrderService
{
	
	private $orderRepository;
	private $cupomRepository;
	private $productRepository;

	public function __construct(
			OrderRepository $orderRepository, 
			CupomRepository $cupomRepository, 
			ProductRepository $productRepository
		)
	{
		$this->orderRepository = $orderRepository;
		$this->cupomRepository = $cupomRepository;
		$this->productRepository = $productRepository;
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

	public function create(array $data)
	{

		\DB::beginTransaction();

		try{

			$data['status'] = 0;

			if(isset($data['cupom_code'])){
				$cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
				$data['cupom'] = $cupom->id;
				$cupom->used = 1;
				$cupom->save();
				unset($data['cupom_code']);
			}

			$items = $data['items'];
			unset($data['items']);

			$order = $this->orderRepository->create($data);

			$total = 0;

			foreach ($items as $item) {
				$item['price'] = $this->productRepository->find($item['product_id'])->price;
				$order->items()->create($item);
				$total += $item['price'] * $item['qtd'];
			}

			$order->total = $total;
			if(isset($cupom)){
				$order->total = $total - $cupom->value;
			}
			$order->Save();
			
			\DB::commit();

			return $order;

		}catch(\Exception $e){
			
			\DB::rollback();
			throw $e;
		}
		
	}

	public function updateStatus($idOrder, $idDeliveryman, $status)
	{
		$order = $this->orderRepository->buscarOrdensPorIdEDeliveryman($idOrder, $idDeliveryman);

		if($order instanceof Order){
			$order->status = $status;
			$order->save();
			return $order;
		}
		return false;
	} 
}