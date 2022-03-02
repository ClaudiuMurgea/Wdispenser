@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <a href="{{ route('add_product_form') }}" class="btn btn-success mb-1" onclick="showLoadingOverlay()"  >Add Product</a>
    </div>
    <br/>
    <div class="container-fluid">
        <table class="table table-sm table-responsive-sm table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Picture</th>
                    {{-- <th>Slot</th> --}}
                    <th>Name</th>
                    <th>Details</th>
                    <th>Temperature</th>
                    <th>Cost Points</th>
                    <th>Cost Money</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->ResourceType != '')
                                <img src="{{ url('/product-tumb/' . $product->Id . '/list') }}" alt="" width="100" />
                            @else
                                <img src="{{ asset('/img/no-image.png') }}" width="100" />
                            @endif
                        </td>
                        {{-- <td>{{ $product->Slot }}</td> --}}
                        <td>{{ $product->Name }}</td>
                        <td>{{ $product->Details }}</td>
                        <td>{{ $product->Temperature }}</td>
                        <td>{{ $product->Cost }}</td>
                        <td>{{ $product->CostMoney }}</td>
                        <td>
                            <div class="btn-group btn-sm">
                                <a href="{{ route('edit_product', ['id' => $product->Id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('product_to_dispenser', ['id' => $product->Id]) }}" class="btn btn-sm btn-primary">Add to dispenser</a>
                                <a href="{{ route('product_to_locker', ['id' => $product->Id]) }}" class="btn btn-sm btn-info">Add to locker</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
@endsection

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            hideLoadingOverlay();
        });
    </script>
@endsection
