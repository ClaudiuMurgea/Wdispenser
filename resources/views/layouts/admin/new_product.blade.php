@extends('layouts.app')

@section('content')
    <br/>
    <div class="container container-fluid">
        <div class="card">
            <div class="card-body">
              @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                <h5 class="card-title">Add Product</h5>
                <form action="{{ route('store_product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="productFile" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control-file" id="productFile" name="product_image" value="{{ old('product_image') }}">
                         
                        </div>
                    </div>
                    <div class="row mb-3">
                      <label for="productName" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="productName" name="product_name" value="{{ old('product_name') }}">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="productDetails" class="col-sm-2 col-form-label">Details</label>
                      <div class="col-sm-10">
                        <textarea id="productDetails" style="width: 100%" name="product_details" rows="4">{{old('product_details')}}</textarea>
                      </div>
                    </div>
                    <div class="row mb-3">
                        <label for="productTemperature" class="col-sm-2 col-form-label">Temperature</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="productTemperature" name="product_temperature" value="{{ old('product_temperature') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="productCostPoints" class="col-sm-2 col-form-label">Cost Points Dispenser</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="productCostPoints" name="product_cost_points" value="{{ old('product_cost_points') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="productCostMoney" class="col-sm-2 col-form-label">Cost Money Dispenser</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="productCostMoney" name="product_cost_money" value="{{ old('product_cost_money') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                      <label for="productCostPointsLocker" class="col-sm-2 col-form-label">Cost Points Locker</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="productCostPointsLocker" name="product_cost_points_locker">
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="productCostMoneyLocker" class="col-sm-2 col-form-label">Cost Money Locker</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="productCostMoneyLocker" name="product_cost_money_locker">
                      </div>
                  </div>
                  <div class="row mb-3">
                    <label for="dispenseTime" class="col-sm-2 col-form-label">Dispense Time</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="dispenseTime" name="dispense_time">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="dispenseAmount" class="col-sm-2 col-form-label">Dispense Amount</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="dispenseAmount" name="dispense_amount">
                    </div>
                  </div>
                    <div class="row mb-3">
                        <label for="productType" class="col-sm-2 col-form-label">Product Type</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="productType" name="product_type">
                                <option value="">Please select</option>
                                @foreach ($productTypes as $productType)
                                    <option value="{{ $productType->Name }}">{{ $productType->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success">Create Product</button>
                    </div>
                  </form>
            </div>
          </div>
    </div>
    
@endsection

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            hideLoadingOverlay();
        });
    </script>
@endsection
