@extends('layouts.app')

@section('content')
    <br/>
    <div class="container container-fluid">
        <table class="table table-sm table-striped table-responsive-sm table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Temperature</th>
                    <th>Cost Points</th>
                    <th>Cost Money</th>
                    <th>Slot</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <form action="#" id="userSelectionForm" method="POST">
                    @csrf
                    @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->ResourceType != '')
                                    <img src="{{ url('/product-tumb/' . $product->Id . '/wine') }}" alt="" width="100" />
                                @else
                                    <img src="{{ asset('/img/no-image.png') }}" width="100" />
                                @endif
                            </td>
                            <td>{{ $product->Name }}</td>
                            <td>{{ $product->Details }}</td>
                            <td>{{ $product->Temperature }}</td>
                            <td>{{ $product->Cost }}</td>
                            <td>{{ $product->CostMoney }}</td>
                            <td>{{ $product->Slot }}</td>
                            <td>
                                <div class="btn-group btn-group-lg btn-group-sm mb-3">
                                    <a class="btn btn-sm btn-warning" role="button" aria-pressed="true" href="{{ route('wine_dispenser_edit', ['id' => $product->Id]) }}" >Edit</a>
                                    <a class="btn btn-sm btn-success" role="button" aria-pressed="true" href="{{ route('wine_dispenser_change_product', ['id' => $product->Id]) }}" >Change product</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </form>
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
