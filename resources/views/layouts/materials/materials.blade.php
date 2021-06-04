@extends('layouts.app')

@section('content')
    <div class="container-fluid">
{{--        <button class="btn btn-secondary mb-1" type="button" data-toggle="modal" data-target="#largeModal">Add Material</button>--}}
        <a href="{{ route('create_material') }}" class="btn btn-secondary mb-1" type="button">Add material</a>
    </div>
    <br>
    <div class="container container-fluid">
        <table class="table table-responsive-sm table-hover table-outline mb-0>
            <thead class="thead-light">
        <tr>
            <th>Material Name</th>
            <th>Material Code</th>
            <th>Role</th>
            <th>API Token</th>
            <th>Status/Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($materials as $material)
            <tr>
                <td>{{ $material['material_name'] }}</td>
                <td>{{ $material['material_code'] }}</td>
                <td>Member</td>
                <td>*******************</td>
                <td><span class="badge badge-success w-100">Active</span></td>
            </tr>
        @endforeach
        </tbody>
        </table>
    </div>
    <div class="modal fade" id="largeModal" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new material</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header"><strong>Company</strong> <small>Form</small></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input class="form-control" id="company" type="text" placeholder="Enter your company name">
                            </div>
                            <div class="form-group">
                                <label for="vat">VAT</label>
                                <input class="form-control" id="vat" type="text" placeholder="PL1234567890">
                            </div>
                            <div class="form-group">
                                <label for="street">Street</label>
                                <input class="form-control" id="street" type="text" placeholder="Enter street name">
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-8">
                                    <label for="city">City</label>
                                    <input class="form-control" id="city" type="text" placeholder="Enter your city">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="postal-code">Postal Code</label>
                                    <input class="form-control" id="postal-code" type="text" placeholder="Postal Code">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <input class="form-control" id="country" type="text" placeholder="Country name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button">Add material</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
