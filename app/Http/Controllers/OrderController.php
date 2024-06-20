<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {

  public function index($id) {
    $orders = Order::where('user_id', $id)->get();

    // if ($orders->isEmpty()) {
    //   return response()->json([
    //     'message' => 'Order not found',
    //     'id' => $id
    //   ], 404);
    // }

    return response()->json([
      'orders' => $orders
    ], 200);

    // return response()->json([
    //   'message' => 'Order not found',
    //   'id' => $id
    // ], 404);
  }

  public function create(Request $request) {

    $user = AppUser::where('id', $request->user_id)->exists();

    if (!$user) {
      return response()->json([
        'message' => 'User not found'
      ], 404);
    }

    $order = new Order();
    $order->name = $request->name;
    $order->email = $request->email;
    $order->total = $request->total;
    $order->user_id = $request->user_id;
    $order->address = $request->address;
    $order->products = $request->products;
    $order->subtotal = $request->subtotal;
    $order->discount = $request->discount;
    $order->delivery = $request->delivery;
    $order->phone_number = $request->phone_number;
    $order->card_holder_name = $request->card_holder_name;

    $order->save();

    return response()->json([
      'message' => 'Order created successfully',
      'order' => $order
    ], 200);
  }
}
