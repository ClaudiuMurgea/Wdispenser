@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <div class="card">
            <form action="{{ route('store_material') }}" method="POST">
                @csrf
                <div class="card-header"><strong>Material</strong> <small>Form</small></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="material_name">Material Name</label>
                        <input class="form-control" id="material_name" type="text" name="material_name" placeholder="Enter material name">
                    </div>
                    <div class="form-group">
                        <label for="material_code">Material Code</label>
                        <input class="form-control" id="material_code" type="text" name="material_code" placeholder="Enter material code">
                    </div>

                    <div class="form-group text-right">
                        <input type="submit" class="btn btn-sm btn-success" value="Add material" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
