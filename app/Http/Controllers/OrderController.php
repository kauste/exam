<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function backOrder(){
        $orders = Order::all();
        $orders = $orders->map(function ($order) {
             $cart = json_decode($order->cart, 1);
             foreach($cart as &$item){
                $item['dish_name'] = Dish::where('id', $item['dish_id'])
                                    ->select('dish_name')
                                    ->first()?->dish_name;
                $item['restaurant'] = Dish::join('menus', 'dishes.menu_id', '=', 'menus.id')
                                    ->join('restaurants', 'menus.id', '=', 'restaurants.menu_id')
                                    ->where('dishes.id', $item['dish_id'])
                                    ->select('restaurants.restaurant_name')
                                    ->first()?->restaurant_name;
             };
             $order->cart = $cart;
             $order->user = User::where('id', '=', $order->user_id)
                                ->select('name')
                                ->first()
                                ->name;
             return $order;
        });
       
        return view('back.order.index', ['orders'=> $orders, 'states' => Order::STATES]);
    }
    public function changeState(Request $request, $id){
        $req = $request->all();
        $req['id'] = $id;
      
        $validator = Validator::make($req,
        [
            'state' => ['required', 'integer'],
            'id' => ['required', 'integer'],
        ], 
        [
            'state.required'=> 'State is required.',
            'state.integer'=> 'State is not valid.',
            'id.required'=> 'Order id is required.',
            'id.integer'=> 'Order id is not valid.',
        ]);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        };
        Order::where('id', '=', $id)
                        ->update(['state' => $request->state]);
        return redirect()->back()->with('message', 'State is changed.');

    }
    public function addToCart (Request $request, $dishId, $restaurantId){
        
        $dishId = (int) $dishId;
        $restaurantId = (int) $restaurantId;

        $validator = Validator::make([],[]);

        $validator->after(function ($validator) use ($dishId, $restaurantId) {

                if(!$dishId){
                $validator->errors()->add("dishId","Sorry, this dish could not be ordered.");
                }
                if(!$restaurantId){
                    $validator->errors()->add("dishId","Sorry, this restaurant is unavailible.");
            }
        });

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        };
        $orderInProgress =  $request->session()->get('items', []);
        $orderInProgress[]= ['dish_id'=> $dishId, 'amount'=>$request->amount, 'restaurant_id' => $restaurantId];
        $request->session()->put('items', $orderInProgress);

        return redirect()-> back()->with('mesaage', 'Item is added to your cart');
    }
    public function showCart(Request $request){
        $cart = collect($request->session()->get('items', []));

        $cart = $cart->map(function($dish){
            $dish['dish_name'] = Dish::where('id', $dish['dish_id'])
                                    ->select('dish_name')
                                    ->first()
                                    ->dish_name;
            $dish['restaurant_name'] = Restaurant::where('id', $dish['restaurant_id'])
                                    ->select('restaurant_name')
                                    ->first()
                                    ->restaurant_name;
                                  
            return $dish;
        });


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
    public function orderList(){
        $carts = Order::where('user_id', '=', Auth::user()->id)
        ->get();
        
        $carts = $carts->map(function($order){
            $decoded = json_decode($order->cart, 1);
            foreach($decoded as &$food){
                $food['dish_name'] = Dish::where('id', $food['dish_id'])
                                    ->select('dish_name')
                                    ->first()?->dish_name;
                $food['restaurant'] = Restaurant::where('id', $food['restaurant_id'])
                                    ->select('restaurant_name')
                                    ->first()?->restaurant_name;
            }
            $order->cart = $decoded;
            return $order;
        });

 
        return view('front.order', ['orders'=> $carts, 'states' => Order::STATES]);
    }
    public function clientDeleteOrder($id){
        $restaurantId = (int) $id;

        $validator = Validator::make([],[]);

        $validator->after(function ($validator) use ($id) {
                if(!$id){
                    $validator->errors()->add("id","Sorry, you cannot delete this order.");
            }
        });

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        };
        Order::where('id', '=', $id)->delete();

        return redirect()->back()->with('message', 'Order is canceled!');
    }

    public function clientEditOrder($id){
        $restaurantId = (int) $id;

        $validator = Validator::make([],[]);

        $validator->after(function ($validator) use ($id) {
                if(!$id){
                    $validator->errors()->add("id","Sorry, you cannot delete this order.");
            }
        });

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        };
        $order = Order::where('id', '=', $id)->first();
        $decoded = json_decode($order->cart, 1);
            foreach($decoded as &$food){
                $food['dish_name'] = Dish::where('id', $food['dish_id'])
                                    ->select('dish_name')
                                    ->first()?->dish_name;
                $food['restaurant'] = Restaurant::where('id', $food['restaurant_id'])
                                    ->select('restaurant_name')
                                    ->first()?->restaurant_name;
            }
            $order->cart = $decoded;

        return view('front.editOrder', ['order'=> $order]);
    }
    public function orderItemDelete($orderId, $dishId){
        $order = Order::where('id', '=', $orderId)->first();
        $decoded = json_decode($order->cart, 1);
            foreach($decoded as $key => &$food){
                if($food['dish_id'] == $dishId){
                    unset($decoded[$key]);
                }
            }
        $order->cart = json_encode($decoded);
        $order->save();
        
        return redirect()->back()->with('message', 'Dish is deleted from your order');
    }
    public function editAmounts(Request $request){

        foreach($request->all()['amounts'] as &$dish){
            $dish['dish_id'] = (int) $dish['dish_id'];
            $dish['amount'] = (int) $dish['amount'];
        };

        $messages = [];

            foreach($request->all()['amounts'] as $dish){
                if($dish['dish_id']){
                    $messages[] = 'Amount could not be edited.';

                }
                if($dish['amount']){
                    $messages[] = 'Amount should be a number.';
                }
            };

        if(count($messages) != 0){
            return response()->json([
                'errors'=> $messages,
            ]);
        }
        $edit = $request->all();
        $amounts = $edit['amounts'];
        $order = Order::where('id',$edit['orderId'])
                    ->first();
        $cart = collect(json_decode($order->cart));
        $cart = $cart->map(function($food) use ($amounts){
            foreach($amounts as $amount){
                if($amount['dish_id'] == $food->dish_id){
                    $food->amount = $amount['amount'];
                    break;
                }
            }
            return $food;
        });
        $order->cart = json_encode($cart);
        $order->save();
        $request->session()->flash('message', 'Order ir edited');
         return response()->json([
            'message'=> 'Order ir edited',
        ]);
    }
}
