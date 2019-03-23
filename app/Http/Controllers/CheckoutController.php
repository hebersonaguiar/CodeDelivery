<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Http\Request;

use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Http\Controllers\Controller;

class CheckoutController extends Controller
{

	private $repository;
    private $userRepository;
    private $productRepository;

	public function __construct(OrderRepository $repository, UserRepository $userRepository, ProductRepository $productRepository)
	{
		$this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
	}

    // public function index()
    // {

    // 	$categories = $this->repository->paginate();


    // 	return view('admin.categories.index', compact('categories'));
    // }

    public function create()
    {
    	$products = $this->productRepository->lists('name','id');

        return view('customer.order.create', compact('products'));
    }
s

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
