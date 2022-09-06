@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-8 justify-content-center">
            <div class="card-header">
                <h1>My orders</h1>
            </div>
            @forelse($orders as $key => $order)
            <div class="card  justify-content-center m-2">
                <div class="card-header ord-card-header">
                    <h2>{{$key + 1}} order</h2>
                    <p><b>State:</b> {{$states[$order['state']]}}</p>
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
                            <div>
                                @foreach($order->cart as $item)
                                <tr>
                                    <td scope="col">{{$item['dish_name'] ?? 'Not availible'}}</td>
                                    <td cope="col">{{$item['amount']}}</td>
                                    <td cope="col">{{$item['restaurant'] ?? 'Not availible'}}</td>

                                </tr>
                                @endforeach
                            </div>
                        </tbody>
                    </table>
                    <div class="controls">
                        <form method="post" action="{{route('client-delete-order',  $order['id'])}}">
                            @if($order['state'] == 2) <div><i>Sorry, your order ir canceled.</i></div> @endif
                            @if($order['state'] == 3) <div><i>Order is delivered.</i></div> @endif
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-primary">@if($order['state'] == 0)Cancel order @elseif($order['state'] == 2) Seen @elseif($order['state'] == 2) Got it @endif</button>
                        </form>
                        @if($order['state'] == 0)
                            <a href="{{route('client-edit-order',  $order['id'])}}" class="btn btn-outline-primary">Edit order</a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div>No orders</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
