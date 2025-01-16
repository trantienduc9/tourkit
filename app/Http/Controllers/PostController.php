<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Category; // Model cho Categorye
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('tourkit.posts.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Post $post = null)
    {
        $categories = Category::all();

        return view('tourkit.posts.form', compact('categories', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create($request->toArray());

        // Attach categories to posts
        $post->categories()->attach($request->categories);

        foreach ($post->categories as $category) {
            // increase views for category
            $category->increment('view_count', $post->view_count);
        }

        return redirect()->route('posts.index')->with('success', 'Post added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return $this->create($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $post->update($request->toArray());

        $post->categories()->sync($request->categories);

        foreach ($post->categories as $category) {
            // increase views for category
            $category->increment('view_count', $post->view_count);
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post):bool
    {
        return $post->delete();
    }

    public function getData(Request $request){
        $postsQuery = Post::with('categories')->select('posts.id', 'posts.title', 'posts.view_count', 'posts.created_at')->orderBy('id', 'DESC');

        if ($request->keyword) {
            $postsQuery->where('title', 'like', '%' . trim($request->keyword) . '%');
        }

        if ($request->categories) {
            $postsQuery->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->categories);
            });
        }

        return DataTables::of($postsQuery)
            ->addColumn('categories', function ($post) {
                return $post->categories->map(fn($category) => '<div> - ' . $category->title . '</div>')
                    ->implode('');
            })
            ->addColumn('title', function ($post) {
                return '<a class="text-decoration-none text-primary" href="' . route("posts.edit", $post->id) . '">' . $post->title . '</a>';
            })
            ->addColumn('action', function ($post) {
                return '<button class="btn btn-danger delete-post" data-id="' . $post->id . '">Delete</button>';
            })
            ->addColumn('created_at', function ($post) {
                return formatDate($post->created_at);
            })
            ->rawColumns(['categories', 'title', 'action', 'created_at'])
            ->make(true);
    }
}
