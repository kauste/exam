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
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" action="{{route('order')}}">
                            @foreach($cart as $item)
                            <tr>
                                <td scope="row">{{$item['dish_name']}}</td>
                                <td scope="row">{{$item['amount']}}</td>
                            </tr>
                            @endforeach

                            @csrf
                            @method('post')
                            <button class="btn btn-outline-danger" type="submit">Order</button>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
