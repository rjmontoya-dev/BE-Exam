<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list(Request $request){
        $products = Product::with('media')
        ->where(function ($query) use ($request){
            $query->when($request->has('query'), function ($query) use ($request) {
                $queryString = trim($request['query']);
                $query->where('name', 'LIKE', "%{$queryString}%")
                ->orWhere('description', 'LIKE', "%{$queryString}%");
            });
            $query->when($request->has('categorySearch'),function ($query) use ($request){
                $queryString = trim($request['categorySearch']);
                $query->where('category', 'LIKE', "%{$queryString}%");
            });
        })
        ->orderBy('created_at','asc')
        ->paginate(5)
        ->withQueryString();
        return response()->json([
            'products' => $products,
        ]);
    }
    public function store(StoreProductRequest $request){
        $product = Product::create([
            'name'=>$request->name,
            'category'=>$request->category,
            'description'=>$request->description,
            'created_at'=>$request->date_time,
        ]);
        if ($images = $request->file('images')) {
            foreach ($images as $image) {
                $product->addMedia($image)
                    ->usingName($product->name)
                    ->toMediaCollection('images');
            }
        }
        return response()->json([]);
    }
    public function update(UpdateProductRequest $request){

        $id = $request->id;
        $find = Product::findOrFail($id);
        $find->update([
            'name'=>$request->name,
            'category'=>$request->category,
            'description'=>$request->description,
            'created_at'=>$request->date_time,
        ]);

        if($images = $request->file('images')){
                if ($request->hasFile('images') ) {
                    $find->clearMediaCollection('images');
                }
                foreach($images as $image){
                     $find->addMedia($image)
                    ->usingName($find->name)
                    ->toMediaCollection('images');
                }

            }

    }
    public function destroy($id){
        $find = Product::findOrFail($id);
        $find->delete();
        $find->clearMediaCollection('images');
        $products = Product::paginate(5);
        return response()->json(['products' => $products]);
    }
}
