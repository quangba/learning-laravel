@extends('layout.index')

@section('content')
    <div class="mt-5">
        <h2 class="text-center">
            LIST FOODS
        </h2>
    </div>
    @if (session('msg'))
        <div class="alert alert-success" role="alert" style="width: 500px">
            {{ session('msg') }}
        </div>
    @endif

    <a type="button" class="btn btn-primary mt-2 mb-5" href="{{ route('food.create') }}">Create product</a>
    <div class="row">
        <table class="table table-success table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    {{-- <th scope="col">Image</th> --}}
                    <th scope="col">Name</th>
                    <th scope="col">Detail</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-light">
                @if (!empty($foods))
                    @foreach ($foods as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            {{-- <td><img src="/images/{{ $item->image }}" width="200px" /></td> --}}
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->count }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <a href="{{ route('food.show', $item->id) }}" class="btn btn-info">Show</a>
                                <a href="{{ route('food.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('food.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Data not found!!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
