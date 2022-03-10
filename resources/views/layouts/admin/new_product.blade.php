@extends('layouts.app')

@section('content')
    <br/>
    <div class="container container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Product</h5>
                <form action="{{ route('store_product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="productFile" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control-file" id="productFile" name="product_image">
                         
                        </div>
                    </div>
                    <div class="row mb-3">
                      <label for="productName" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="productName" name="product_name">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="productDetails" class="col-sm-2 col-form-label">Details</label>
                      <div class="col-sm-10">
                        <textarea id="productDetails" style="width: 100%" name="product_details" rows="4"></textarea>
                      </div>
                    </div>
                    <div class="row mb-3">
                        <label for="productTemperature" class="col-sm-2 col-form-label">Temperature</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="productTemperature" name="product_temperature">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="productCostPoints" class="col-sm-2 col-form-label">Cost Points Dispenser</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="productCostPoints" name="product_cost_points">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="productCostMoney" class="col-sm-2 col-form-label">Cost Money Dispenser</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="productCostMoney" name="product_cost_money">
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
                      <label for="dispensableAmount" class="col-sm-2 col-form-label">Dispensable Amount</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="dispensableAmount" name="default_dsp_value">
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
