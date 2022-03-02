@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <div class="card" style="background-color: #FCFCFC; width: 45rem;">
            <br/>
            <img class="card-img-top" src="{{ url('/product-image/' . $product->Id) }}" alt="Product image" width="100" />
            <form action="{{ route('send_product_to_locker') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->Id }}" >
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $product['Name'] }}</h2>
                        <h4>{{ $product['Details'] }}</h4>
                    </div>

                    <br/>
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Slot</th>
                                <th>Select</th>
                                <th>Product Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slots as $slot)
                                <tr>
                                    <td>{{ $slot['Slot'] ?? '' }}</td>
                                    <td>
                                        <input type="checkbox" class="input-lg" name="update_slots[]" value="{{ $slot['LockerNr'] }}"  > 
                                    </td>
                                    <td>{{ $slot['Name'] ?? 'Free' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                
                <div style="width: 75%; margin-left: auto; margin-right: auto">
                    <div class="text-right">
                        <input type="submit" class="btn btn-lg btn-warning" value="Update">
                    </div>
                    <br/><br/>
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
