<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Ixudra\Curl\Facades\Curl;
class PaymentController extends Controller
{
    
    public function pay(Request $request)
    {  
        // dd($request);
        try {
            $data=[
                'totalAmount'=> [
                    'value'=> $request->total_amount,
                    'currency'=> env('MAYA_CURRENCY')
                ],
                "buyer"=>[
                    "firstName" => Auth::user()->name, 
                    "lastName" => Auth::user()->name
                ],
                'requestReferenceNumber'=> "5fc10b93-bdbd-4f31-b31d-4575a3785009",
                "redirectUrl"=> [
                    "success"=> "http://127.0.0.1:8000/success", 
                ],
            ];
            $response = Curl::to('https://pg-sandbox.paymaya.com/checkout/v1/checkouts')
            ->withHeader('accept: application/json')
            ->withHeader('authorization: Basic '.env('MAYA_AUTH_API_KEY'))
            ->withHeader('content-type: application/json')
            ->withData($data) 
            ->asJson()
            ->post();  
            return response()->json(['data'=>$response]);
           
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function success()
    {
        $find = Cart::where('user_id',Auth::id())->delete(); 
        return inertia('Admin/Ecommerce/Cart/Index',['message'=>"Paid"]);
    }
}
