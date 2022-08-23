@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-8 p-5">
            <div class="card-header">
                <h1>Create new dish</h1>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" method="post" action="{{route('dish-store')}}">
                    <div class="form-row d-flex">
                        <div class="col-md-5">
                            <label for="name">Name</label>
                            <input id="name" required type="text" class="form-control" name="dish_name">
                        </div>
                        <div class="col-md-5">
                            <label>Menu name</label>
                            <select class="form-control" name="menu_id">
                                @foreach($menus as $menu)
                                <option value="{{$menu->id}}">{{$menu->menu_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-">
                            <label for="desciption">Description</label>
                            <textarea required id="desciption" type="number" class="form-control" name="description" cols="50" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md controls">
                            <label for="picture">Add picture</label>
                            <input id="picture" type="file" name="picture">
                        </div>
                    </div>
                    <div class="form-row align-items-center d-flex">
                        @csrf
                        @method('post')
                        <button type="submit" class="btn btn-primary m-3">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

      
