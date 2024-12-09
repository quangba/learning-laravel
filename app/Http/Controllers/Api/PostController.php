<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    protected $posts;

    public function __construct(Post $post)
    {
        $this->posts = $post;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->posts->paginate(5);

        // Lấy data đầy đủ
        // $postsResource = PostResource::collection($posts)->response()->getData(true); // Trả về đây đủ link, meta....
        $postsResource = PostResource::collection($posts);  // chỉ có dữ liệu

        // chỉ in ra dữ liệu, nếu muốn custom data thì vào PostCollection
        $postsCollection =  new PostCollection($posts);

        // return response()->json([
        //     'postData' => $postsCollection
        // ], Response::HTTP_OK );

        return $this->sendResponseSuccess($postsCollection, 'success', Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $postCreate = $request->all();

        $post = $this->posts->create($postCreate);
        $postsResource = new PostResource($post);

        // return response()->json([
        //     'postData' => $postsResource
        // ], Response::HTTP_OK );
        return $this->sendResponseSuccess($postsResource, 'create success', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->posts->findOrFail($id);

        $postsResource = new PostResource($post);

        // return response()->json([
        //     'postData' => $postsResource
        // ], Response::HTTP_OK );
        return $this->sendResponseSuccess($postsResource, 'success', Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = $this->posts->findOrFail($id);
        $postUpdate = $request->all();

        $post->update($postUpdate);

        $postsResource = new PostResource($post);

        // return response()->json([
        //     'postData' => $postsResource
        // ], Response::HTTP_OK );
        return $this->sendResponseSuccess($postsResource, 'update success', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->posts->findOrFail($id);
        $post->delete();
        $postsResource = new PostResource($post);

        // return response()->json([
        //     'postData' => $postsResource,
        //     'message' => 'delete success',
        // ], Response::HTTP_OK );
        return $this->sendResponseSuccess($postsResource, 'delete success', Response::HTTP_OK);
    }
}
