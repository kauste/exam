<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurant::join('menus', 'restaurants.menu_id', '=', 'menus.id')
        ->select('menus.*', 'restaurants.*')
        ->get();
        return view('back.restaurant.index', ['restaurants'=> $restaurants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.restaurant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRestaurantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $restaurant = new Restaurant;
        $restaurant->restaurant_name = $request->restaurant_name;
        $restaurant->city = $request->city;
        $restaurant->adress = $request->adress;
        $restaurant->save();
        return redirect()-> route('restaurants-list')->with('message', 'New restaurant is added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        return view('back.restaurant.edit', ['restaurant'=> $restaurant]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRestaurantRequest  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $restaurant->restaurant_name = $request->restaurant_name;
        $restaurant->city = $request->city;
        $restaurant->adress = $request->adress;
        $restaurant->save();
        return redirect()-> route('restaurants-list')->with('message', 'Information about this restaurant is edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->back()->with('message', 'Restaurant is deleted.');
    }
}
