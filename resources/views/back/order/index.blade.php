@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-8 justify-content-center">
            <div class="card-header">
                <h1>My orders</h1>
            </div>
            @forelse($orders as $order)
            <div class="card m-2 justify-content-center">
                <div class="card-header">
                    <h1>{{$order->user}} cart</h1>
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

                            @foreach($order['cart'] as $cart)
                            <tr>
                                <th scope="col">{{$cart['dish_name'] ?? 'Not availible'}}</th>
                                <th cope="col">{{$cart['amount']}}</th>
                                <td cope="col">{{$cart['restaurant'] ?? 'Not availible'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form method="post" action="{{route('change-state', $order->id)}}">
                        <div class="controls">
                            <label>Change state</label>
                            <select name="state">
                                @foreach($states as $key => $state)
                                <option value="{{$key}}" @if($order->state == $key) selected @endif>{{$state}}</option>
                                @endforeach
                            </select>
                            @csrf
                            @method('put')
                            @if($order->state < 2)
                            <button class="btn btn-outline-danger" type="submit">Change state</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <div>No orders<div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
