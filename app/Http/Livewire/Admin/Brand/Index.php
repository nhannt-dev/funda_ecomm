<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $slug, $status;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string',
            'status' => 'nullable'
        ];
    }

    public function resetInput()
    {
        $this->name = null;
        $this->slug = null;
        $this->status = null;
    }
    
    public function storeBrand()
    {
        $validate = $this->validate();
        Brand::create([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'status' => $this->status == true ? '1' : '0'
        ]);
        session()->flash('message', 'Thuong hieu da them thanh cong!');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }
    
    public function render()
    {
        $brands = Brand::orderBy('id', 'ASC')->paginate(10);
        return view('livewire.admin.brand.index', compact('brands'))
                    ->extends('layouts.admin')
                    ->section('content');
    }
}
