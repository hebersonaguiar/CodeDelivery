<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\CategoryRepository;
use Illuminate\Http\Request;

use CodeDelivery\Http\Requests\AdminProductRequest;
use CodeDelivery\Http\Controllers\Controller;

class OrdersController extends Controller
{

	private $repository;

	public function __construct(OrderRepository $repository)
	{
		$this->repository = $repository;
	}

    public function index()
    {

    	$orders = $this->repository->paginate();


    	return view('admin.orders.index', compact('orders'));
    }

    // public function create()
    // {
    //     $categories = $this->categoryRepository->lists('name','id');

    // 	return view('admin.orders.create', compact('categories'));
    // }

    // public function store(AdminProductRequest $request)
    // {
    // 	$data = $request->all();
    // 	$this->repository->create($data);

    // 	return redirect()->route('admin.orders.index');
    // }

    // public function edit()
    // {
        // $product = $this->repository->find($id);
        // $categories = $this->categoryRepository->lists('name','id');

        // return view('admin.orders.edit', compact('product','categories'));
    // }

    // public function update(AdminProductRequest $request, $id)
    // {
    //     $data = $request->all();
    //     $this->repository->update($data, $id);

    //     return redirect()->route('admin.orders.index');
    // }

    // public function destroy($id)
    // {
    //     $this->repository->delete($id);

    //     return redirect()->route('admin.orders.index');
    // }
}
