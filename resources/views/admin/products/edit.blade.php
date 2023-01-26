@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Product
                        <a href="{{ route('product') }}" class="btn btn-primary btn-sm text-white float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('updateproduct', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo-tab-pane" type="button" role="tab" aria-controls="seo-tab-pane" aria-selected="false">SEO Tags</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-tab-pane" type="button" role="tab" aria-controls="detail-tab-pane" aria-selected="false">Detail</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="false">Image</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade border p-3 show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <div class="mb-3">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="slug">Product Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{ $product->slug }}">
                                </div>
                                <div class="mb-3">
                                    <label for="brand">Brand</label>
                                    <select name="brand" id="brand" class="form-control">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->name }}" {{ $brand->name == $product->brand ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="small_description">Small Description</label>
                                    <textarea class="form-control" name="small_description" id="small_description" rows="4">{{ $product->small_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="4">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade border p-3" id="seo-tab-pane" role="tabpanel" aria-labelledby="seo-tab" tabindex="0">
                                <div class="mb-3">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ $product->meta_title }}">
                                </div>
                                <div class="mb-3">
                                    <label for="meta_keyword">Meta Keyword</label>
                                    <textarea name="meta_keyword" id="meta_keyword" rows="4" class="form-control">{{ $product->meta_keyword }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea class="form-control" name="meta_description" id="meta_description" rows="4">{{ $product->meta_description }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade border p-3" id="detail-tab-pane" role="tabpanel" aria-labelledby="detail-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="original_price">Original Price</label>
                                            <input type="text" name="original_price" id="original_price" class="form-control" value="{{ $product->original_price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="selling_price">Selling Price</label>
                                            <input type="text" name="selling_price" id="selling_price" class="form-control" value="{{ $product->selling_price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $product->quantity }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="trending">Trending</label>
                                            <input type="checkbox" name="trending" id="trending" {{ $product->trending == '1' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status">Status</label>
                                            <input type="checkbox" name="status" id="status" {{ $product->status == '1' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade border p-3" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                <div class="mb-3">
                                    <label for="image">Upload Image</label>
                                    <input type="file" name="image[]" id="image" multiple class="form-control">
                                </div>
                                <div>
                                    @if ($product->productImage)
                                    <div class="row">
                                        @foreach ($product->productImage as $img)
                                            <div class="col-md-2">
                                                <img src="{{ asset($img->image) }}" style="width: 80px;height: 80px" class="me-4 border" alt="">
                                                <a href="{{ route('removeimage', $img->id) }}" class="d-block">Remove</a>
                                            </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection