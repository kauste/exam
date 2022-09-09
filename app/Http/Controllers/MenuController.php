<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
        return view('back.menu.index', ['menus'=> $menus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'menu_name' => ['required', 'min:5','max:50'],
        ], 
        [
            'menu_name.required'=> 'Menu name is required.',
            'menu_name.min'=> 'Menu name should be at least 5 symbols length.',
            'menu_name.max'=> 'Menu name should be not longer than 50 symbols.',
        ]);
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        };

        $menu = new Menu;
        $menu->menu_name = $request->menu_name;
        $menu->save();
        return redirect()-> route('menu-list')->with('message', 'New menu is added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return view('back.menu.edit', ['menu'=> $menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(),
        [
            'menu_name' => ['required', 'min:5','max:50'],
        ], 
        [
            'menu_name.required'=> 'Menu name is required.',
            'menu_name.min'=> 'Menu name should be at least 5 symbols length.',
            'menu_name.max'=> 'Menu name should be not longer than 50 symbols.',
        ]);
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        };
        $menu->menu_name = $request->menu_name;
        $menu->save();
        return redirect()-> route('menu-list')->with('message', 'Menu is edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->back()->with('message', 'Menu is deleted.');
    }
}
