<div class="card mb-4">
    <div class="card-header">Search</div>
    <div class="card-body">
        <form  method="get" action="{{route('front-restaurant-list')}}">
            <div class="container">
                <div class="row">
                    <div class="col-10">
                        <div class="form-group">
                            <label>Do search</label>
                            <input class="form-control" type="text" name="s" value="" />
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-outline-warning mt-4">Search!</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>