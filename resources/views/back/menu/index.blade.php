@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-6 justify-content-center">
            <div class="card-header">
                <h1>Our menus</h1>
            </div>
            <div class="card-body ">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Menu name</th>
                            <th cope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                        <tr>
                            <td scope="row">{{$menu->menu_name}}</td>
                            <td class="controls">
                                <a href="{{route('menu-edit', $menu)}}" class="btn btn-outline-success">EDIT</a>
                                <form method="post" action="{{route('menu-delete', $menu)}}">
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
