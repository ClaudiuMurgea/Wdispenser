<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\SmartLocker;
use App\Models\WineDispenser;

use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ă'=>'a', 'Ă'=>'A', 'ș'=>'s', 'Ș'=>'S', 'ț'=>'t', 'Ț'=>'T');
    //
    public function index(){
        return view('layouts.admin.products')->with('products', Product::all());
    }

    public function create(){
        return view('layouts.admin.new_product')->with('productTypes', ProductType::all());
    }

    public function store(Request $request){
        $formData = $request->all(); //dd($formData);
        $file = $request->file('product_image');
        // Get the contents of the file
        $productImageData = $file->openFile()->fread($file->getSize());
        $productImageType = $request->file('product_image')->extension();

        $productDetails = strtr($formData['product_details'], $this->unwanted_array);

        $newProduct = [
            'Name'                      => $formData['product_name'] ?? '',
            'Details'                   => $productDetails,
            'Resource'                  => $productImageData,
            'ResourceType'              => $productImageType,
            'ProductType'               => $formData['product_type'] ?? NULL,
            'CostPointsDispenser'       => $formData['product_cost_points'] ?? '',
            'CostMoneyDispenser'        => $formData['product_cost_money'] ?? 0,
            'CostPointsLocker'          => $formData['product_cost_points_locker'] ?? 0,
            'CostMoneyLocker'           => $formData['product_cost_money_locker'] ?? 0,
            'MaxDispensableAmount'      => $formData['max_dsp_amount'] ?? 0,
            'DefaultDispensableValue'   => $formData['default_dsp_value'] ?? 0,
            'Temperature'               => $formData['product_temperature'] ?? '',
        ];

        Product::create($newProduct);

        //dd($newProduct);

        return redirect()->route('products_list');
    }

    public function edit($id){

    }

    public function showSendToDispenser($id){
        $slotsCount = 4; // wine dispenser total slots, todo: add this inb settings

        $product = Product::find($id);

        $productsInLocker = (new WineDispenser)->get(['Slot', 'Name', 'Details'])->toArray();
        $productsInLockerAssoc = [];
        if(!empty($productsInLocker)){
            foreach($productsInLocker as $productInDispenser){
                $productsInLockerAssoc[$productInDispenser['Slot']] = $productInDispenser;
            }
        }

        $slots = [];
        for( $i = 1; $i <= $slotsCount; $i++ )
        {
            if(!empty($productsInLockerAssoc[$i])){
                $slots[] = 
                    [
                        'Slot'      => $i,
                        'Name'      => $productsInLockerAssoc[$i]['Name'],
                        'Details'   => $productsInLockerAssoc[$i]['Details']
                    ];
            }
            else{
                $slots[] = 
                [
                    'Slot'      => $i,
                    'Name'      => 'Free',
                    'Details'   => ''
                ];
            }
        }
 
        return view('layouts.admin.send_to_dispenser_form')->with('product', $product)->with('slots', $slots);
    }

    public function sendToDispenser(Request $request){
        $formData = $request->all();

        $productData = Product::find($formData['product_id']);

        $slotsToUpdate = $formData['update_slots'];

        if(!empty($slotsToUpdate) && is_array($slotsToUpdate)){
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
            
            foreach($slotsToUpdate as $slotToUpdate){
                $affectedRows = WineDispenser::where('Slot', '=', $slotToUpdate)->update($slotData);
            }

        }

        return redirect()->route('wine_dispenser');
    }

    public function showSendToLocker($id){
        $slotsCount = 32; // locker total slots, todo: add this inb settings

        $product = Product::find($id);
        $productsInLocker = (new SmartLocker)->get(['LockerNr', 'Name', 'Details'])->toArray();// dd($product);
        $productsInLockerAssoc = [];
        if(!empty($productsInLocker)){
            foreach($productsInLocker as $productInLocker){
                $productsInLockerAssoc[$productInLocker['LockerNr']] = $productInLocker;
            }
        }
        
        $slots = [];
        for( $i = 1; $i <= $slotsCount; $i++ )
        {
            if(!empty($productsInLockerAssoc[$i])){
                $slots[] = 
                    [
                        'LockerNr'  => $i,
                        'Name'      => $productsInLockerAssoc[$i]['Name'],
                        'Details'   => $productsInLockerAssoc[$i]['Details']
                    ];
            }
            else{
                $slots[] = 
                [
                    'LockerNr'  => $i,
                    'Name'      => 'Free',
                    'Details'   => ''
                ];
            }
        }


        return view('layouts.admin.send_to_locker_form')->with('product', $product)->with('slots', $slots);
    }

    public function sendToLocker(Request $request){
        $formData = $request->all();

        $productData = Product::find($formData['product_id']);

        $slotsToUpdate = $formData['update_slots'];

        if(!empty($slotsToUpdate) && is_array($slotsToUpdate)){
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

            foreach($slotsToUpdate as $slotToUpdate){
                $affectedRows = SmartLocker::where('LockerNr', '=', $slotToUpdate)->update($slotData);
            }

        }

        return redirect()->route('smart_locker');
    }
}
