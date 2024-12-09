@extends('layout.index')

@section('content')
    <div class="mt-5">
        <h2 class="text-center">
            DETAIL FOODS
        </h2>
    </div>
    <div class="row">
        @if (!empty($food) && !empty($food->category))
            <div class="mb-3 col-xs-12 col-md-12 col-sm-12">
                <strong for="name" class="form-label">Name: </strong>
                {{ $food->name }}
            </div>
            <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <strong for="detail" class="form-label">Count: </strong>
                {{ $food->count }}
            </div>
            <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <strong for="detail" class="form-label">Detail: </strong>
                {{ $food->description }}
            </div>
            <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <strong for="detail" class="form-label">category_id: </strong>
                {{ $food->category_id }}
            </div>
            <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <strong for="detail" class="form-label">category name: </strong>
                {{ $food->category->name }}
            </div>
            <div class="mb-3 mb-3 col-xs-12 col-md-12 col-sm-12">
                <strong for="image" class="form-label">Image: </strong>
               <img src="/images/{{ $food->image_path }}" width="300px" />
            </div>
        @else
            <div>No Data</div>
        @endif
        <div class="col-xs-12 col-md-12 col-sm-12 text-center mt-5">
            <a href="{{ url('/foods') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
