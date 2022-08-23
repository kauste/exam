@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-8 p-5">
            <div class="card-header">
                <h1>Edit menu</h1>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('menu-update', $menu)}}">
                    <div class="form-row align-items-center d-flex">
                        <div class="col-md-7">
                            <label for="menu_name">Name of menu</label>
                            <input required type="text" class="form-control" name="menu_name" value="{{$menu->menu_name}}">
                        </div>
                    </div>
                    <div class="form-row align-items-center d-flex">
                    @csrf
                    @method('put')
                        <button type="submit" class="btn btn-primary m-3">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection