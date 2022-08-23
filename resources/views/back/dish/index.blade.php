@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                <h1>Our dishes</h1>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                              <th cope="col"></th>
                            <th scope="col">Dish Name</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Description</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($dishes as $dish)
                        <tr>
                            <td><img class="img" @if($dish->picture_path) src="{{$dish->picture_path}}" @else src="{{asset('/images') . '/like.jpg'}}" @endif ></td>
                            <td scope="row">{{$dish->dish_name}}</th>
                            <td>{{$dish->menu_name}} eu.</td>
                            <td>{{$dish->description}}</td>
                            <td class="controls">
                                <a href="{{route('dish-edit', $dish)}}" class="btn btn-outline-success">EDIT</a>
                                <form method="post" action="{{route('dish-delete', $dish)}}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger" type="submit">DELETE</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection