<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function Index()
    {
        return view('admin.category.index');
    }
    
    public function Create()
    {
        return view('admin.category.create');
    }

    public function Store(CategoryFormRequest $request)
    {
        $validate = $request->validated();
        $category = new Category();
        
        $category->name = $validate['name'];
        $category->slug = Str::slug($validate['slug']);
        $category->description = $validate['description'];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/category/',$filename);
            $category->image = $filename;
        }
        $category->meta_title = $validate['meta_title'];
        $category->meta_keyword = $validate['meta_keyword'];
        $category->meta_description = $validate['meta_description'];
        $category->status = $request->status == true ? '1' : '0';
        $category->save();

        return redirect()->route('category')->with('message', 'Danh muc duoc them thanh cong');
    }

    public function Edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function Update(CategoryFormRequest $request, $category)
    {
        $validate = $request->validated();
        $category = Category::findOrFail($category);
        
        $category->name = $validate['name'];
        $category->slug = Str::slug($validate['slug']);
        $category->description = $validate['description'];
        if ($request->hasFile('image')) {
            $path = 'uploads/category/'.$category->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/category/',$filename);
            $category->image = $filename;
        }
        $category->meta_title = $validate['meta_title'];
        $category->meta_keyword = $validate['meta_keyword'];
        $category->meta_description = $validate['meta_description'];
        $category->status = $request->status == true ? '1' : '0';
        $category->update();
        
        return redirect()->route('category')->with('message', 'Danh muc duoc cap nhat thanh cong');
    }
}
