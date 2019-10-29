<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
         $product = Product::paginate();

         return response()->json([
             'data' => $product,
             'status' => 200         
         ], 200);
    }

    public function show($id)
    {
       $findId = Product::where('id',$id)->get();

       return response()->json([
           'data' => $findId
       ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            'message' => 'Successfully Delete'
        ], 200);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'product_name' => 'required',
            'product_price' => 'required', 
        ]);

        $product = Product::find($id);
        $product->product_name = $req->product_name;
        $product->product_price = $req->product_price;

        $product->save();

        return response()->json([
            'message' => 'Successfully update',
            'data'    => $product
        ]);

    }


}
