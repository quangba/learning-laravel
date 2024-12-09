@extends('layout.index')

@section('content')
    <div class="mt-5">
        <h2 class="text-center">
            EDIT PRODUCT
        </h2>
    </div>
    <form action="{{ route('food.update', $food->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-3 col-xs-12 col-md-12 col-sm-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="name..."
                    value="{{ $food->name }}">
                @error('name')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-xs-12 col-md-12 col-sm-12">
                <label for="count" class="form-label">Count</label>
                <input type="number" class="form-control" id="count" name="count" placeholder="count..."
                    value="{{ $food->count }}">
            </div>
            <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <label for="detail" class="form-label">Description</label>
                <textarea type="text" class="form-control" id="detail" name="detail" placeholder="detail..."
                    style="height: 120px" value="{{ $food->description }}">{{ $food->description }}</textarea>
                @error('detail')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            {{-- <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" id="image" name="image" placeholder="image...">
                @error('image')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div> --}}
            <div class="col-xs-12 col-md-12 col-sm-12 text-center mt-5">
                <a href="{{ url('/foods') }}" class="btn btn-secondary">Back</a>
                <button type="Submit" value="Submit" class="btn btn-primary">Edit product</button>
            </div>
        </div>
    </form>
@endsection
