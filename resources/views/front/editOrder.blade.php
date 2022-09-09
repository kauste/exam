@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-8 justify-content-center">
            <div class="card-header">
                <h2 data-order-id="{{$order->id}}">Edit order</h2>
            </div>
            <div class="card-body ">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Dish</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Restaurant</th>
                             <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <div>
                            @foreach($order->cart as $item)
                            <tr>
                                <td scope="col">{{$item['dish_name'] ?? 'Not availible'}}</td>
                                <td scope="col-1"><input name="{{$item['dish_id']}}" value="{{$item['amount']}}" </td>
                                <td scope="col">{{$item['restaurant'] ?? 'Not availible'}}</td>
                                <td cope="col">
                                    <form method="post" action="{{route('order-item-delete', [$order->id, $item['dish_id']])}}">
                                            @csrf
                                           @method('delete')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                            </tr>
                            @endforeach
                        </div>
                    </tbody>
                </table>
                        <button type="button" class="btn btn-danger edit--amounts--btn">Edit</button>
            </div>
        </div>
    </div>
</div>
@endsection
