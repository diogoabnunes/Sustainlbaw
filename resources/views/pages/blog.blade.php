@extends('layouts.app', ['title' => 'Blog'])

@section('content')

    <main id="conteudos" tabindex="0"
        class="w-100 container-default px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">

        @if (@isset($_GET['message'])){
            <div class="alert alert-success" role="alert">
                {{ $_GET['message'] }}
            </div>
            }
        @endif

        <h1 class="pb-4">Blog</h2>

            <div id="blog-categories" class="d-none d-lg-block">
                <a href="/blog" id="all_categories" class="btn btn-secondary">Todas</a>

                @foreach ($blog_categories as $category)
                    <a data-id="{{ $category->category_id }}" onclick="selectCategory(event)"
                        id="{{ 'category_' . $category->category_id }}" class="category btn btn-outline-secondary"><i
                            class="fas {{ $category->icon_label }}"></i>&nbsp;&nbsp;{{ $category->name }}</a>
                @endforeach
            </div>

            <div id="blog-posts-container">
                @if (Auth::check() && Auth::user()->isEditor())
                    <a href="/blog_post_crud" class="blog-post blog-add-post">
                        <h4><i class="fas fa-plus"></i>&nbsp;&nbsp;Nova Publicação</h4>
                    </a>
                @endif

                @foreach ($posts as $post)
                    @include('partials.blog.blog_post', $post)
                @endforeach

            </div>
            <div id="blog-load-more" class="pt-5 w-100 d-flex flex-column gap-2 justify-content-center align-items-center">
                <div class="d-inline-flex flex-row justify-content-center  ">
                    {{ $posts->links() }}

                </div>
            </div>

            <script src="../js/app.js"></script>
            <script src="../js/blog/categories.js"></script>

    </main>





@endsection
