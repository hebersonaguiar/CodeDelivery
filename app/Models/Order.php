<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Order.
 *
 * @package namespace CodeDelivery\Models;
 */
class Order extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'user_deliveryman_id',
        'total',
        'status',

    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryman()
    {
        return $this->belongsTo(User::class,'user_deliveryman_id','id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
