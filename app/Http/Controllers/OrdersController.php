<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
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

    public function edit($id, UserRepository $userRepository)
    {
        $list_status = [0=>'Psendente', 1=>'A caminho', 2=>'Entregue', 3=>'Cancelado'];
        $order = $this->repository->find($id);
        $deliveryman = $userRepository->getDeliveryman(['role'=>'deliveryman'], ['name','id']);

        return view('admin.orders.edit', compact('order','list_status','deliveryman'));
    }

    public function update(Request $request, $id)
    {
        $all = $request->all();
        $this->repository->update($all, $id);

        return redirect()->route('admin.orders.index');
    }

    // public function destroy($id)
    // {
    //     $this->repository->delete($id);

    //     return redirect()->route('admin.orders.index');
    // }
}
