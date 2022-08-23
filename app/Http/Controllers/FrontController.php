<?php

namespace App\Http\Controllers;
use App\Models\Restaurant;
use App\Models\Dish;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function restaurantList(Request $request){

        $request->filter ?? 0;
        if($request->s){
            $search_words = explode(' ', trim($request->s));
            if(count($search_words) > 1 ){
                $search_words = array_slice($search_words, 0, );
            }

            $restaurants = Restaurant::join('menus', 'restaurants.menu_id', '=', 'menus.id')
            ->select('menus.*', 'restaurants.*')
            ->where(function($case) use ($search_words){
                foreach($search_words as $word){
                    $case->where('restaurants.restaurant_name', 'like', '%'. $word.'%');
                }
            })->get();
        }
        else {
        $restaurants = Restaurant::join('menus', 'restaurants.menu_id', '=', 'menus.id')
        ->select('menus.*', 'restaurants.*')
        ->get();
        }
        return view('front.restaurants', ['restaurants'=> $restaurants]);
    }
    public function dishesList(){
        
    }

    public function restaurantMenu(Restaurant $restaurant){
        $menu = Dish::join('menus', 'dishes.menu_id', '=', 'menus.id')
        ->select('dishes.dish_name', 'dishes.picture_path','dishes.description', 'menus.menu_name', 'dishes.id')
        ->where('dishes.menu_id', $restaurant->menu_id)
        ->get();
        return view('front.restaurantMenu', ['menu'=> $menu]);
    }

}
