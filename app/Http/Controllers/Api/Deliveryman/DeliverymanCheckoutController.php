<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use CodeDelivery\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Http\Controllers\Controller;

class DeliverymanCheckoutController extends Controller
{

	private $repository;
    private $userRepository;
    private $productRepository;
    private $service;

	public function __construct(OrderRepository $repository, UserRepository $userRepository, ProductRepository $productRepository, OrderService $service)
	{
		$this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->service = $service;
	}

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $orders = $this->repository->with(['items'])->scopeQuery(function($query) use($id) {
            return $query->where('user_deliveryman_id','=',$id);
        })->paginate();

    	return $orders;
    }

    public function show($id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->repository->getByIdAndDeliveryman($id,$idDeliveryman);
    }

    public function updateStatus(Request $request, $id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->service->updateStatus($id, $idDeliveryman, $request->get('status'));

        if ($order) {
            return $order;
        }

        abort(400, "Order não encontrada");
    }
}
