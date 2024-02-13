<?php

namespace App\Http\Controllers\API\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
     
    public function cartListItems(){
        $cartItems = Cart::with('products' )->get(); 
        return response()->json(['cartListItems'=>$cartItems]);
    }
    public function addToCart($id){ 
        $find = Product::findOrFail($id); 
        $productExistToCart =  Cart::where('product_id',$id)->first();  
        if($productExistToCart){
            Cart::where('product_id',$id)->update(['qty' => ($productExistToCart['qty']+=1)]);
        }else{ 
           Cart::create(['user_id'=> Auth::id(),'product_id'=>$find->id,'qty'=>1]);
        }
    }
    public function removeToCart($id){
        $find = Cart::findOrFail($id);
        $find->delete(); 
        $cartItems = Cart::with('products')->get(); 
        return response()->json(['cartListItems'=>$cartItems]); 
    }
    public function update_qty($id,Request $request){
        $find = Cart::findOrFail($id); 
        $params = $request['params']; 
        if($params['increasing']){
            $find->update(['qty'=>$find->qty+=1]); 
        }else{
            $find->update(['qty'=>$find->qty-=1]);
        }
        $cartItems = Cart::with('products')->get();
        return response()->json(['cartListItems'=>$cartItems]);
    }
}
