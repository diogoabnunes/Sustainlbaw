<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Auth;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('view', Auth::user());
        if (!Auth::user()->isEditor())
            return view('errors.403');
        $blog_categories = BlogCategory::join('category', 'blog_category.blog_category_id', '=', 'category.category_id')->distinct('category.category_id')->get(['category.category_id','category.name']);
        return view('pages.blog_post_crud', ['blog_categories' => $blog_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(String $activeCategories)
    {

        if(!isset($activeCategories)){
            return ['posts' => null];
        }

        $categories = explode (",", $activeCategories);

        
        $posts = BlogCategory::whereIn('blog_category.blog_category_id', $categories)->
        join('blog_post', 'blog_category.blog_post_id', '=', 'blog_post.blog_post_id')->distinct('blog_post.blog_post_id')->get(['blog_post.*', 'blog_category.blog_category_id']); 


        foreach ($posts as $post) {
            $post['categories'] = BlogCategory::where('blog_category.blog_post_id', '=', $post->blog_post_id)->
            join('category', 'blog_category.blog_category_id', '=', 'category.category_id')->get(['blog_category.blog_category_id', 'category.name', 'category.icon_label']);
        }

        $editor = false;
        if(Auth::check() && Auth::user()->isEditor()){
            $editor = true;
        }

        return ['posts' => $posts, 'editor' => $editor];      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogCategory $blogCategory)
    {
        //
    }
}
