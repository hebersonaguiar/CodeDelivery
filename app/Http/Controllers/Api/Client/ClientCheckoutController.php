<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

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

class ClientCheckoutController extends Controller
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
    	$clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->repository->with(['items'])->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id','=',$clientId);
        })->paginate();

    	return $orders;
    }

    public function store(Request $request)
    {
        $id = Authorizer::getResourceOwnerId();
        $data = $request->all();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $obj = $this->service->create($data);
        $order = $this->repository->with('items')->find($obj->id);

        return $order; 
    }


    public function show($id)
    {
        $order = $this->repository->with(['client','items','cupom'])->find($id);
        $order->items->each(function($item){
            $item->product;
        });
        return $order;
    }


    // public function update(AdminCategoryRequest $request, $id)
    // {
    //     $data = $request->all();
    //     $this->repository->update($data, $id);

    //     return redirect()->route('admin.categories.index');
    // }
}
