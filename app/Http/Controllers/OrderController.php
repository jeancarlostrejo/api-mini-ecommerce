<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['user:id,name,email', 'location'])->paginate(20);

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found', "data" => []], 200);
        }

        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $productsData = $request->validated()["products"];

        DB::beginTransaction();

        try {
            $order = Order::create($request->only(['user_id', 'total_price', 'date_of_delivery']) + ["location_id" => Location::where("user_id", $request->user_id)->first()->id]);
    
    
            foreach ($productsData as $productData) {
                $product = Product::find($productData['product_id']);
    
                if ($product->amount < $productData['quantity']) {
                    throw new \Exception("Product {$product->name} is out of stock");
                }
    
                $product->amount -= $productData['quantity'];
                $product->save();
    
                $order->products()->attach($productData['product_id'], ['quantity' => $productData['quantity'], 'price' => $productData['price']]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Order created successfully', 'data' => $order], 201);
    }

     /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResponse
    {
        $order->load(['user:id,name,email', 'location:id,street,building,area', 'products' => function ($query) {
            $query->select('products.id', 'products.name', 'categories.name as category', 'products.category_id', 'order_product.price as price', 'order_product.quantity as quantity');
            $query->join('categories', 'products.category_id', '=', 'categories.id');;
        }]);

        return response()->json($order);
    }
}