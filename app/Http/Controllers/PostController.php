<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\CreatePostRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;


class PostController extends Controller
{


    /**
     * index
     * @param Request $request
     * @return View
     */
    public function index(
        Request $request
    ): View {
        $posts = Post::latest()->with('user')->paginate(5);
        return view('posts.index', compact('posts'));
    }

    /**
     * create
     * @return View
     */
    public function create(): View
    {
        return view('posts.create');
    }


    /**
     * store
     * @param  CreatePostRequest $request
     * @return RedirectResponse
     */
    public function store(
        CreatePostRequest $request
    ): RedirectResponse {
        try {

            Post::create(array_merge(
                $request->validated(),
                ['user_id' => auth()->id()]
            ));

            return to_route('posts.index')
                ->withInput();

        } catch (\Throwable $th) {

            Log::error('Create posts error: ' . $th->getMessage());

            return to_route('posts.index')
                ->withInput();
        }
    }

    /**
     * edit
     * @param  Post $post
     * @return View
     */
    public function edit(
        Post $post
    ): View {
        return view('posts.edit', compact('post'));
    }


    /**
     * update
     * @param  Post $post
     * @param  CreatePostRequest $request
     * @return RedirectResponse
     */
    public function update(
        Post $post,
        CreatePostRequest $request
    ): RedirectResponse {
        
        try {

          $post->update($request->validated());

            return redirect(route('posts.index'))
                ->withInput();

        } catch (\Throwable $th) {
            
            Log::error('Create posts error: ' . $th->getMessage());

            return redirect(route('posts.index'))
                ->withInput();
        }
    }


    /**
     * destroy
     * @param  Post $post
     * @return RedirectResponse
     */
    public function destroy(
        Post $post
    ): RedirectResponse {
        try {
            $post->delete();

            return to_route('posts.index')
                ->withInput();

        } catch (\Throwable $th) {

            Log::error('Delete posts error: ' . $th->getMessage());

            return to_route('posts.index')
                ->withInput();
        }
    }
}