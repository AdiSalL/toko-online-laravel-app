<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        // OTORISASI GATE
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-orders')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
            });
    }
    public function index(Request $request)
    {
        //
        $status = $request->get("status");
        $buyer_email = $request->get("buyer_email");

        $orders = Order::with("user")->with("books")->whereHas("user", function($query) use ($buyer_email) {
            $query->where("email", "LIKE", "%$buyer_email%");
        })
        ->where("status", "LIKE", "%$status%")
        ->paginate(10);
        return view("orders.index", [
            "orders" => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $order = Order::findOrFail($id);
        return view("orders.edit", [
            "order" => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->status = $request->get("status");
        $order->save();
        return redirect()->route("orders.edit", [$order->id])->with("status", "Order status succesfully updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
