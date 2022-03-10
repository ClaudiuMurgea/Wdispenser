<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SmartLocker;

use Illuminate\Http\Request;

class SmartLockerController extends Controller
{
    //
    public function index(){

        return view('layouts.user.smart_locker')->with('products', SmartLocker::all());
    }

    /***
     * show the view for product change on locker
     */
    public function changeProduct($slotId){
        $slot = ['LockerNr'=> $slotId];

        $products = Product::all();


        return view('layouts.user.change_locker_product_form')->with('slot', $slot)->with('products', $products);
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
            'CostPoints'                => $productData->Cost ?? 0,
            'CostMoney'                 => $productData->CostMoney,
            'ProductType'               => $productData->ProductType,
            'Resource'                  => $productData->Resource,
            'ResourceType'              => $productData->ResourceType,
            'ResourceVersion'           => 1,
            'isAvabile'                 => 'No'
        ];

        $response = [
            'type' => 'error',
            'message' => 'Update failed for locker #' . $slotId
        ];

        $lockerSlotData = SmartLocker::where('LockerNr', $slotId)->firstOrFail();
        if(!empty($lockerSlotData->Id)){
            $r = SmartLocker::where('Id', '=', $lockerSlotData->Id)->update($slotData);

            if($r){
                $response = [
                    'type'      => 'message',
                    'message'   => 'Locker #' . $slotId . ' updated!'
                ];
            }
        }

        return redirect()->route('smart_locker')->with($response['type'], $response['message']);
    }

    public function edit($id){

    }

    public function update($id){

    }
}
