<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WineDispenser;

use Illuminate\Http\Request;

class WineDispenserController extends Controller
{
    //
    public function index(){

        return view('layouts.user.wine_dispenser')->with('products', WineDispenser::all());
    }

    public function changeProduct($slotId){
        $slot = ['Slot'=> $slotId];

        $products = Product::all();


        return view('layouts.user.change_wine_product_form')->with('slot', $slot)->with('products', $products);
    }

    /**
     * save new product to locker
     */
    public function pushProduct(Request $request, $slotId){
        $formData = $request->all();
        $productId = array_key_first($formData['products']);

        $productData = Product::find($productId);

        $slotData = [
            'Name'                      => $productData->Name,
            'Details'                   => $productData->Details,
            'Resource'                  => $productData->Resource,
            'ResourceType'              => $productData->ResourceType,
            'ResourceVersion'           => 1,
            'Cost'                      => $productData->Cost ?? 0,
            'CostMoney'                 => $productData->CostMoney,
            'Amount'                    => $productData->Amount ?? 0,
            'User'                      => 'EGTS',
            'MaxDispensableAmount'      => $productData->MaxDispensableAmount,
            'DefaultDispensableValue'   => $productData->DefaultDispensableValue,
            'Temperature'               => $productData->Temperature
        ];

        $response = [
            'type' => 'error',
            'message' => 'Update failed for slot #' . $slotId
        ];

        $wineSlotData = WineDispenser::where('Slot', $slotId)->firstOrFail(); //dd($wineSlotData->all());
        if(!empty($wineSlotData->Id)){
            $r = WineDispenser::where('Id', '=', $wineSlotData->Id)->update($slotData);

            if($r){
                $response = [
                    'type'      => 'message',
                    'message'   => 'Locker #' . $slotId . ' updated!'
                ];
            }
        }

        return redirect()->route('wine_dispenser')->with($response['type'], $response['message']);
    }

    public function edit($id){

    }

    public function update($id){
        
    }
}
