<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Dcp;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$posts = BlogPost::all();
        $pagination = 12;
        if (Auth::check() && Auth::user()->isEditor()) {
            $pagination = 11;
        }


        $posts = BlogPost::orderBy('publication_date', 'desc')->paginate($pagination);

        $blog_categories = BlogCategory::join('category', 'blog_category.blog_category_id', '=', 'category.category_id')->distinct('category.category_id')->get(['category.category_id', 'category.name', 'category.icon_label']);

        foreach ($posts as $post) {
            $post['categories'] = BlogCategory::where('blog_category.blog_post_id', '=', $post->blog_post_id)->join('category', 'blog_category.blog_category_id', '=', 'category.category_id')->get(['blog_category.blog_category_id', 'category.name', 'category.icon_label']);
        }
        //return $posts[0];
        return view('pages.blog', ['posts' => $posts, 'blog_categories' => $blog_categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', BlogPost::class);
        //$blog_categories = $this->getAllCategories();

        if (!$this->validateRequest($request) || !$request->hasFile('image_path')) {
            return redirect('/blog_post_crud?error');
        }

        $blogPost = new BlogPost();
        //$this->authorize('create', $blogPost);
        $blogPost->title = $request->input('title');
        $blogPost->author = $request->input('author');
        $blogPost->image_path = $this->uploadImg($request, $blogPost);
        $blogPost->content = $request->input('content');
        $blogPost->editor = Auth::user()->user_id;

        $blogPost->save();

        if ($request->has('categories')) {
            foreach ($request->categories as $category) {
                $blogCategory = new BlogCategory();
                $blogCategory->blog_post_id = $blogPost->blog_post_id;
                $blogCategory->blog_category_id = $category;
                $blogCategory->save();
            }
        } else {
            $blogCategory = new BlogCategory();
            $blogCategory->blog_post_id = 5;
            $blogCategory->blog_category_id = 'Outro';
            $blogCategory->save();
        }


        return redirect('/blog/' . $blogPost->blog_post_id . '/?CreateBlog="success"');
    }

    public function validateRequest(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|min:1',
                'author' => 'required|string|min:1',
                'content' => 'required|string|min:1',
            ]
        );
        if ($validator->fails() || !$request->has('categories')) {
            return false;
        }
        return true;
    }

    public function uploadImg(Request $request, $eventPost)
    {
        if ($request->hasFile('image_path')) {

            $filename = $request->image_path->getClientOriginalName();
            $request->image_path->storeAs('images', $filename, 'public');
            return $filename;
        } else return $eventPost->image_path;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $post = BlogPost::find($id);
        if ($post == null) return view('errors.notfound');
        $comments = $post->comments()->orderby('date', 'DESC')->get();
        $categories = BlogCategory::where('blog_category.blog_post_id', '=', $post->blog_post_id)->join('category', 'blog_category.blog_category_id', '=', 'category.category_id')->get(['blog_category.blog_category_id', 'category.name', 'category.icon_label']);

        return view('pages.blog_post', ['post' => $post, 'comments' => $comments, 'categories' => $categories]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->authorize('update', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        $post = BlogPost::find($id);
        $blog_categories = $this->getAllCategories();
        $post['categories'] = BlogCategory::where('blog_category.blog_post_id', '=', $post->blog_post_id)->join('category', 'blog_category.blog_category_id', '=', 'category.category_id')->get(['blog_category.blog_category_id', 'category.name']);

        for ($i = 0; $i < count($blog_categories); $i++) {
            $found = false;
            for ($j = 0; $j < count($post['categories']); $j++) {
                if ($blog_categories[$i]->name == $post['categories'][$j]->name) {
                    $found = true;
                }
            }
            if ($found == true) {
                $blog_categories[$i]['found'] = true;
            } else {
                $blog_categories[$i]['found'] = false;
            }
        }

        $dcp = DB::table('district_county_parish')
            ->select('district')->distinct('district')
            ->get();

        return view('pages.blog_post_crud', ['post' => $post, 'blog_categories' => $blog_categories, 'districts' => $dcp]);
    }

    public function getAllCategories()
    {
        return BlogCategory::join('category', 'blog_category.blog_category_id', '=', 'category.category_id')->distinct('category.category_id')->get(['category.category_id', 'category.name']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$this->validateRequest($request)) {
            return redirect('/blog/' . $id . '/edit?errorEdit');
        }
        $blogPost = BlogPost::find($id);
        $this->authorize('update', $blogPost);
        $blogPost->title = $request->input('title');
        //$blogPost->image_path = "../assets/product3.jpg"; //$request->input('image_path');
        $blogPost->image_path = $this->uploadImg($request, $blogPost);
        $blogPost->content = $request->input('content');
        $blogPost->author = $request->input('author');
        $blogPost->save();

        // deleting old categories
        BlogCategory::where('blog_category.blog_post_id', '=', $blogPost->blog_post_id)->delete();

        if ($request->has('categories')) {
            foreach ($request->categories as $category) {
                BlogCategory::updateOrCreate(
                    ['blog_post_id' => $blogPost->blog_post_id,
                     'blog_category_id' => $category]);
            }
        } else {
            BlogCategory::updateOrCreate(
                ['blog_post_id' => 5,
                 'blog_category_id' => 'Outro']);
        }

        return redirect('/blog/' . $blogPost->blog_post_id . '/?UpdateBlog="success"'); //view('pages.blog_post', ['post' => $blogPost]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        $blog_post = BlogPost::find($id);
        $blog_post->delete();
        return $blog_post->blog_post_id;
    }
}
