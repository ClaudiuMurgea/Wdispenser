@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <div class="card">
            <form action="{{ route('store_client') }}" method="POST">
                @csrf
                <div class="card-header"><strong>Company</strong> <small>Form</small></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input class="form-control" id="company" type="text" name="client_name" placeholder="Enter your company name">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input class="form-control" id="phone" type="text" name="phone" placeholder="Phone">
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label for="street">Street</label>
                            <input class="form-control" id="street" type="text" name="street_name" placeholder="Enter street name">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="street_number">Street Number</label>
                            <input class="form-control" id="street_number" type="text" name="street_number" placeholder="Enter street number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label for="city">City</label>
                            <input class="form-control" id="city" type="text" name="city_name" placeholder="Enter your city">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="postal-code">Postal Code</label>
                            <input class="form-control" id="postal-code" type="text" name="zip_code" placeholder="Postal Code">
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <input type="submit" class="btn btn-sm btn-success" value="Add client" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
