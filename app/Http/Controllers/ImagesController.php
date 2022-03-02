<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SmartLocker;
use App\Models\WineDispenser;

class ImagesController extends Controller
{
    //
    public function productImage($id){
        $product = Product::find($id); // just in case

        return response()->make($product->Resource, 200, [
            'Content-type: image/jpeg'
        ]);
    }

    public function productImageTumb($id, $table){
        if($table == 'list'){
            $product = Product::find($id);
        }
        elseif($table == 'wine'){
            $product = WineDispenser::find($id);
        }
        elseif($table == 'locker'){
            $product = SmartLocker::find($id);
        }
        else{
            $product = Product::find($id); // just in case
        }

        $image = imagecreatefromstring($product->Resource);
        $image = imagescale($image, 200);
        imagejpeg($image);

        //dd($product->Resource);

        return response()->make($image, 200, [
            'Content-type: image/jpeg'
        ]);
    }
}
