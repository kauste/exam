<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Menu;
use Illuminate\Http\Request;
use Image;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::join('menus', 'menus.id', '=', 'dishes.menu_id')
        ->select('menus.*', 'dishes.*')
        ->get();
        return view('back.dish.index', ['dishes'=> $dishes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::all();
        return view('back.dish.create', ['menus'=> $menus]);
    }

    // $table->id();
    // $table->string('dish_name', 50);
    // $table->text('description');
    // $table->string('picture_path', 300)->nullable();
    // $table->unsignedBigInteger('menu_id');
    // $table->foreign('menu_id')->references('id')->on('menus');
    // $table->timestamps();

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDishRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dish = new Dish;
        $dish->dish_name = $request->dish_name;
        $dish->description = $request->description;
        $dish->menu_id = $request->menu_id;

        if ($request->file('picture')) {
            $photo = $request->file('picture');
            $ext = $photo->getClientOriginalExtension();
            $name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $name. '-' . rand(100000, 999999). '.' . $ext;
            $Image = Image::make($photo);
            $Image->save(public_path().'/images/'.$file);
            $dish->picture_path = asset('/images') . '/' . $file;
        }
        $dish->save();
    

    return redirect()-> route('dish-list')->with('message', 'New dish is added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        $menus = Menu::all();
        return view('back.dish.edit', ['menus'=> $menus, 'dish'=> $dish]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDishRequest  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        if($request->picture){
            //istrinam nuotrauka is publicku
            if($dish->picture_path){
                $pic_asset = $dish->picture_path;
                $name = pathinfo($pic_asset, PATHINFO_FILENAME);
                $ext = pathinfo($pic_asset, PATHINFO_EXTENSION);
                $pic_path = public_path() . '/images/'. $name . '.' .$ext;
                dump($pic_path );
                if (file_exists($pic_path)) {
                    unlink($pic_path);
            }
        }
            //idedam nauja
            $image = $request->file('picture');
            $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $ext  = $image->getClientOriginalExtension();
            $file = $name . '-' . md5($name) . '.' . $ext;
            $img = Image::make($image);
            $img->save(public_path('images/'). $file);
            //linkas i duombaze
            $dish->picture_path = asset('images'). '/'. $file;
    }
    
   
        $dish->dish_name = $request->dish_name;
        $dish->description = $request->description;
        $dish->menu_id = $request->menu_id;
        $dish->save();

        return redirect()->route('dish-list')->with('message', 'Information about dish is edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        if($dish->picture_path){
            $name = pathinfo($dish->picture_path, PATHINFO_FILENAME);
            $ext = pathinfo($dish->picture_path, PATHINFO_EXTENSION);
            $path = public_path('images') . '/' . $name . '.' . $ext;

            if(file_exists($path)) {
                unlink($path);
            }
         }
        $dish->delete();

        return redirect()->back()->with('deleted', 'Dish is no longer included.');
    }
}
