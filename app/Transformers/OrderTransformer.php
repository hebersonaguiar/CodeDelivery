<?php

namespace CodeDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;

/**
 * Class OrderTransformer.
 *
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    // protected $defaultIncludes = ['cupom','items'];
    protected $availableIncludes = ['cupom','items','client'];
    /**
     * Transform the Order entity.
     *
     * @param \CodeDelivery\Models\Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'    => (int) $model->id,
            'total' => (float) $model->total,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeClient(Order $model)
    {
        return $this->item($model->client, new ClientTransformer());
    }

    //Many to one -> Cupom
    public function includeCupom(Order $model)
    {
        if (!$model->cupom) {
            return null;
        }
        return $this->item($model->cupom,new CupomTransformer());
    }

    //One to many -> OrderItems
    public function includeItems(Order $model)
    {
        return $this->collection($model->items,new OrderItemTransformer());
    }
}
