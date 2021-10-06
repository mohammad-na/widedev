<?php

namespace App\Http\Controllers;

use App\Constants\PaymentConstants;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class OrderController extends Controller
{
    public function getOrder(Request $request, $id)
    {
        $order = Order::query()->where('id', '=', $id)->with('products')->get()->toJson();
        return response($order, 200);
    }

    public function getUserOrders(Request $request)
    {
        if (!is_null($request->get('userId'))) {
            $orders = Order::query()->where('user_id', '=', $request->get('userId'))->with('products')->get()->toJson();
            return response($orders, 200);
        }
        return new BadRequestException();
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'user_id' => ['required'],
            'price' => ['required', 'integer'],
            'payment_type' => ['required', 'integer', Rule::in([PaymentConstants::PAYMENT_CREDITCARD, PaymentConstants::PAYMENT_WIRETRANSFER]),],
        ]);

        DB::beginTransaction();
        try {
            $order = new Order();
            $order->price = $request->post('price');
            $order->user_id = $request->post('user_id');
            $order->payment_type = $request->post('payment_type');
            if ($order->save()) {
                foreach ($request->post('products', []) as $product) {
                    $order->products()->attach($product);
                }
                DB::commit();
                return response($order, 201);
            } else {
                DB::rollBack();
                throw new Exception('Error in saving the order.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function updateOrder(Request $request, $id)
    {
        $request->validate([
            'user_id' => ['required', 'nullable'],
            'price' => ['required', 'integer', 'nullable'],
            'payment_type' => ['required', 'integer', Rule::in([PaymentConstants::PAYMENT_CREDITCARD, PaymentConstants::PAYMENT_WIRETRANSFER]), 'nullable'],
            'products' => ['nullable'],
            ]);

        DB::beginTransaction();
        try {
            $order = Order::find($id);
            $order->user_id = is_null($request->post('user_id')) ? $order->user_id : $request->post('user_id');
            $order->price = is_null($request->post('price')) ? $order->price : $request->post('price');
            $order->payment_type = is_null($request->post('payment_type')) ? $order->payment_type : $request->post('payment_type');
            $order->products()->detach();
            foreach ($request->post('products', []) as $product) {
                $order->products()->attach($product);
            }
            if ($order->save()) {
                DB::commit();
                return response($order, 201);
            } else {
                DB::rollBack();
                throw new Exception('Error in saving the order.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
