<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Foods;
use Illuminate\Http\Request;

class FoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $foods = Foods::all(); // select * from foods
        if ($request->expectsJson()) {
            return response()->json($foods, 200);
        }
        return view('foods.index', [
            'foods' => $foods
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('foods.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $foods = new Foods();
        // $foods->name = $request->input('name');
        // $foods->count = $request->input('count');
        // $foods->description = $request->input('detail');
        $genergateImage = '';
        if ($request->image_path) {
            $genergateImage = 'image' . time() . '-' . $request->name . '.' . $request->image_path->extension();
            $request->image_path->move(public_path('images'), $genergateImage);
        }

        $request->validate([
            'name' => 'required|min:5',
            'detail' => 'required',
            // 'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'name không được rỗng',
            'name.min' => 'name phải lơn hơn 5 ký tự',
            'detail.required' => 'detail không được rỗng',
        ]);

        $foods = Foods::create([
            'name' =>  $request->input('name'),
            'count' =>  $request->input('count', 0),
            'description' =>  $request->input('detail'),
            'category_id' => $request->input('category_id'),
            'image_path' => $genergateImage || '',
        ]);
        $foods->save();

        return redirect()->route('food.index')->with('msg', 'Food created success!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Foods  $foods
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $food = Foods::find($id);
        $category = Category::find($food->category_id);
        $food->category = $category;
        return view('foods.show')->with('food', $food);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Foods  $foods
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {

        $food = Foods::findOrFail($id);
        return view('foods.edit')->with('food', $food);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Foods  $foods
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|min:5',
            'detail' => 'required',
        ], [
            'name.required' => 'name không được rỗng',
            'name.min' => 'name phải lơn hơn 5 ký tự',
            'detail.required' => 'detail không được rỗng',
        ]);

        Foods::where('id', $id)->update([
            'name' =>  $request->input('name'),
            'count' =>  $request->input('count'),
            'description' =>  $request->input('detail'),
        ]);
        return redirect()->route('food.index')->with('msg', 'Foods update success!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Foods  $foods
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Foods::find($id)->delete();
        return redirect()->route('food.index')->with('msg', 'Foods deleted success!!');
    }
}
