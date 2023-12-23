<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return inertia('Admin/Product/Index');
    }
    public function create(Request $request){
        return inertia('Admin/Product/Create');
    }
    public function edit($id){
        $find = Product::with('media')->findOrFail($id);
        return inertia('Admin/Product/Create',['products'=>$find]);
    }
}
