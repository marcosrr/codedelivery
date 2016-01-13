<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Database\Eloquent\Collection;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Models\Order;

/**
 * Class OrderRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{

    private $numRegPaginacao;

    public function setNumRegPaginacao($valor)
    {
        $this->numRegPaginacao = $valor;
        return $this;
    }

    public function getNumRegPaginacao()
    {
        return $this->numRegPaginacao;
    }

    public function buscarOrdensPorCliente($clientId)
    {
        #Para retornar os dados apenas das orders
        /*return $this->scopeQuery(function($query) use ($clientId) {
            return $query->where('client_id','=',$clientId);
        })->paginate($this->numRegPaginacao);*/

        #Para retornar os dados das orders mais os itens delas
        return $this->with(['items'])->scopeQuery(function($query) use ($clientId) {
            return $query->where('client_id','=',$clientId);
        })->paginate($this->numRegPaginacao);
    }

    public function buscarOrdensPorDeliveryman($deliverymanId)
    {
        #Para retornar os dados das orders mais os itens delas
        return $this->with(['items'])->scopeQuery(function($query) use ($deliverymanId) {
            return $query->where('user_deliveryman_id','=',$deliverymanId);
        })->paginate($this->numRegPaginacao);
    }

    public function buscarOrdensPorIdEDeliveryman($orderId, $deliverymanId)
    {
        $result = $this->with(['client','items.product','cupom'])->findWhere([
            'id' => $orderId,
            'user_deliveryman_id' => $deliverymanId
        ]);

        if($result instanceof Collection){
            $result = $result->first(); //pega só o primeiro registro
        }

        return $result;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
