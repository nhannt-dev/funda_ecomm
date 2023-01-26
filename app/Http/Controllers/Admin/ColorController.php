<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorFormRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function Index()
    {
        $colors = Color::all();
        return view('admin.color.index', compact('colors'));
    }
    
    public function Create()
    {
        return view('admin.color.create');
    }
    
    public function Store(ColorFormRequest $request)
    {
        $validate = $request->validated();
        $validate['status'] = $request->status == true ? '1' : '0';
        Color::create($validate);
        return redirect()->route('color')->with('message', 'Them bien the mau sac thanh cong!');
    }
    
    public function Edit(Color $color)
    {
        return view('admin.color.edit', compact('color'));
    }
    
    public function Update(ColorFormRequest $request, $id)
    {
        $validate = $request->validated();
        $validate['status'] = $request->status == true ? '1' : '0';
        Color::find($id)->update($validate);
        return redirect()->route('color')->with('message', 'Cap nhat bien the mau sac thanh cong!');
    }
    
    public function Delete($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->route('color')->with('message', 'Xoa bien the mau sac thanh cong!');
    }
}
