<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use CodeDelivery\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Http\Requests\CheckoutRequest;
use CodeDelivery\Http\Controllers\Controller;

class CheckoutController extends Controller
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
    	$clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $orders = $this->repository->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id','=',$clientId);
        })->paginate();

    	return view('customer.order.index', compact('orders'));
    }

    public function store(CheckoutRequest $request){
        $data = $request->all();
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $clientId;
        $this->service->create($data);

        return redirect()->route('customer.order.index'); 
    }

    public function create()
    {
    	$products = $this->productRepository->lists('name','id');

        return view('customer.order.create', compact('products'));
    }

    // public function edit($id)
    // {
    //     $category = $this->repository->find($id);
    //     return view('admin.categories.edit', compact('category'));
    // }

    // public function update(AdminCategoryRequest $request, $id)
    // {
    //     $data = $request->all();
    //     $this->repository->update($data, $id);

    //     return redirect()->route('admin.categories.index');
    // }
}
