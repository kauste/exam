<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Dish;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function backOrder(){
        $orders = Order::all();


        return view('back.order.index', ['orders'=> $orders, 'states' => Order::STATES]);
    }
    public function addToCart (Request $request, $id){

        $orderInProgress =  $request->session()->get('items', []);
        $orderInProgress[]= ['dish_id'=> $id, 'amount'=>$request->amount];
        $request->session()->put('items', $orderInProgress);

        return redirect()-> back()->with('mesaage', 'Item is added to your cart');
    }
    public function showCart(Request $request){
        $cart = $request->session()->get('items', []);
        
        $ids = array_column($cart, 'dish_id');

        $dishes = Dish::whereIn('id', $ids)->get()->toArray();

        foreach($cart as &$item){          
            foreach($dishes as $dish){
                
                if($item['dish_id'] == $dish['id']){
                    $item['dish_name'] = $dish['dish_name'];
                    
                }
            }   
        }


        return view('front.cart', ['cart'=> $cart]);
    }

    public function order(Request $request){
        $cart = $request->session()->pull('items');
        $cartJson = json_encode($cart);

        $order = new Order;
        $order->cart = $cartJson;
        $order->user_id = Auth::user()->id;
        $order->save();
        return redirect()->route('front-restaurant-list')->with('message', 'Thank you, your order is already made.');
    }
}
