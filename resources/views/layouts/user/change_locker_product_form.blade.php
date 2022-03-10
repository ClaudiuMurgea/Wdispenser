@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <div class="card" style="background-color: #FCFCFC; width: 60rem;">
            <br/>
            {{-- <img class="card-img-top" src="{{ url('/product-image/' . $product->Id) }}" alt="Product image" width="100" /> --}}
            <form action="{{ route('locker_push_product', ['slotId' => $slot['LockerNr']]) }}" method="POST">
                @csrf
                {{-- <input type="hidden" name="product_id" value="{{ $product->Id }}" > --}}
                <div class="card-body">
                    <div class="card-title">
                        <h2></h2>
                        <h5 style="white-space: pre-wrap"></h5>
                    </div>

                    <br/>
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        @if($product->ResourceType != '')
                                            <img src="{{ url('/product-tumb/' . $product->Id . '/list') }}" alt="" width="100" />
                                        @else
                                            <img src="{{ asset('/img/no-image.png') }}" width="100" />
                                        @endif
                                    </td>
                                    <td>{{ $product['Name'] ?? '' }}</td>
                                    <td>{{ $product->Details ?? '' }}</td>
                                    <td>
                                        <input type="submit" class="btn btn-sm btn-success" name="products[{{ $product->Id }}]" value="Use Product" >
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
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
