@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                <h1>{{$menu[0]->menu_name}}</h1>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th cope="col"></th>
                            <th scope="col">Dish Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Amount</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($menu as $dish)
                        <form method="post" action="{{route('add-to-cart', $dish->id)}}">
                            <tr classs="align-items">
                                <td><img class="img" @if($dish->picture_path) src="{{$dish->picture_path}}" @else src="{{asset('/images') . '/like.jpg'}}" @endif ></td>
                                <td scope="row">{{$dish->dish_name}}</td>
                                <td>{{$dish->description}}</td>
                                <td><input class="col-2"type="number" name="amount"></td>
                                <td>
                                    @csrf
                                    @method('post')
                                    <button class="btn btn-outline-danger" type="submit">Add</button>
                                </td>
                        </tr>
                         </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection