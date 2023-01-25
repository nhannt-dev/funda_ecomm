<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function Index()
    {
        return view('admin.products.index');
    }
    
    public function Create()
    {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function Store(ProductFormRequest $request)
    {
        $validate = $request->validated();
        $category = Category::findOrFail($validate['category_id']);
        $product = $category->products()->create([
            'category_id' => $validate['category_id'],
            'name' => $validate['name'],
            'slug' => Str::slug($validate['slug']),
            'brand' => $validate['brand'],
            'small_description' => $validate['small_description'],
            'description' => $validate['description'],
            'original_price' => $validate['original_price'],
            'selling_price' => $validate['selling_price'],
            'quantity' => $validate['quantity'],
            'trending' => $request->trending == true ? '1' : '0',
            'status' => $request->status == true ? '1' : '0',
            'meta_title' => $validate['meta_title'],
            'meta_keyword' => $validate['meta_keyword'],
            'meta_description' => $validate['meta_description'],
        ]);

        if($request->hasFile('image')) {
            $uploadPath = 'uploads/products/';
            $i = 1;
            foreach($request->file('image') as $imgFile) {
                $extension = $imgFile->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extension;
                $imgFile->move($uploadPath, $filename);
                $finalImgPathName = $uploadPath.$filename;
                $product->productImage()->create([
                    'product_id' => $product->id,
                    'image' => $finalImgPathName
                ]);
            }
        }
        return redirect()->route('product')->with('message', 'Them san pham thanh cong!');
    }
}
