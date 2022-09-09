@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-6 justify-content-center">
            <div class="card-header">
                <h1>Your cart</h1>
            </div>
            <div class="card-body ">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Dish</th>
                            <th cope="col">Amount</th>
                            <th cope="col">Restaurant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                        <tr>
                            <td scope="row">{{$item['dish_name']}}</td>
                            <td scope="row">{{$item['amount']}}</td>
                            <td scope="row">{{$item['restaurant_name']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(count($cart) == 0)
                <div><i>Your cart is empty</i></div>
                @else
                <form method="post" action="{{route('order')}}">
                    @csrf
                    @method('post')
                    <button class="btn btn-outline-danger" type="submit">Order</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
