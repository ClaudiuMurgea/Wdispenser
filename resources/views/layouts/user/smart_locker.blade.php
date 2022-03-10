@extends('layouts.app')

@section('content')
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
                                    <img src="{{ url('/product-tumb/' . $product->Id . '/locker') }}" alt="" width="100" />
                                @else
                                    <img src="{{ asset('/img/no-image.png') }}" width="100" />
                                @endif
                            </td>
                            <td>{{ $product->Name }}</td>
                            <td>{{ $product->Details }}</td>
                            <td>{{ $product->Temperature }}</td>
                            <td>{{ $product->Cost }}</td>
                            <td>{{ $product->CostMoney }}</td>
                            <td>{{ $product->LockerNr }}</td>
                            <td>
                                <div class="btn-group btn-group-lg btn-group-sm mb-3">
                                    <a class="btn btn-sm btn-warning" role="button" aria-pressed="true" href="{{ route('locker_slot_edit', ['slotId' => $product->LockerNr]) }}" >Edit</a>
                                    <a class="btn btn-sm btn-success" role="button" aria-pressed="true" href="{{ route('locker_change_product', ['slotId' => $product->LockerNr]) }}" >Change product</a>
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
