@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    @forelse($orders as $item)
        <div class="card col-6 justify-content-center">
            <div class="card-header">
                <h1>Person cart</h1>
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
                            @foreach($item['cart'][0] as $dish)
                            <tr>
                                <td scope="row">{{$dish}}</td>
                                {{-- <td scope="row">{{$dish['amount']}}</td> --}}
                            </tr>
                            @endforeach

                            @csrf
                            @method('post')
                            <div class="col-md-5">
                            <label>Menu name</label>
                            <select class="form-control" name="menu_id">
                                @foreach($states as $key => $state)
                                <option value="{{$key}}">{{$state}}</option>
                                @endforeach
                            </select>
                        </div>
                            <button class="btn btn-outline-danger" type="submit">Change state</button>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div>No orders<div>
    @endforelse
</div>
@endsection