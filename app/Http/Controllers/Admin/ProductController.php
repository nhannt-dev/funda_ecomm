<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function Index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
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
    
    public function Edit(int $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }
    
    public function Update(ProductFormRequest $request, int $product_id)
    {
        $validate = $request->validated();
        $product = Category::findOrFail($validate['category_id'])->products()->where('id', $product_id)->first();
        if ($product) {
            $product->update([
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
                'meta_description' => $validate['meta_description']
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
            return redirect()->route('product')->with('message', 'Cap nhat san pham thanh cong!');
        } else {
            return redirect()->route('product')->with('error', 'Khong tim thay id san pham');
        }
        
    }

    public function RemoveImg(int $id)
    {
        $productImg = ProductImage::findOrFail($id);
        if (File::exists($productImg->image)) {
            File::delete($productImg->image);
        }
        $productImg->delete();
        return redirect()->back()->with('message', 'Xoa hinh anh thanh cong');
    }
    
    public function Delete(int $id)
    {
        $product = Product::findOrFail($id);
        if ($product->productImage) {
            foreach($product->productImage() as $img) {
                if (File::exists($img->image)) {
                    File::delete($img->image);
                }
            }
        }
        $product->delete();
        return redirect()->back()->with('message', 'Xoa san pham thanh cong');
    }
}
