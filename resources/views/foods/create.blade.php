@extends('layout.index')

@section('content')
    <div class="mt-5">
        <h2 class="text-center">
            ADD PRODUCT
        </h2>
    </div>
    <form action="{{ route('food.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-xs-12 col-md-12 col-sm-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="name..."
                    value="{{ old('name') }}">
                @error('name')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-xs-12 col-md-12 col-sm-12">
                <label for="count" class="form-label">Count</label>
                <input type="number" class="form-control" id="count" name="count" placeholder="count..."
                    value="{{ old('count') }}">
            </div>
            <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <label for="detail" class="form-label">Detail</label>
                <textarea type="text" class="form-control" id="detail" name="detail" placeholder="detail..."
                    style="height: 120px" value="{{ old('detail') }}"></textarea>
                @error('detail')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <select name="category_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                @foreach ($categories as $category)
                    <option value={{ $category->id }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <label for="image_path" class="form-label">Image</label>
                <input class="form-control" type="file" id="image_path" name="image_path" placeholder="image...">
                @error('image_path')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-xs-12 col-md-12 col-sm-12 text-center mt-5">
                <a href="{{ url('/foods') }}" class="btn btn-secondary">Back</a>
                <button type="Submit" value="Submit" class="btn btn-primary">Create product</button>
            </div>
        </div>
    </form>
@endsection
