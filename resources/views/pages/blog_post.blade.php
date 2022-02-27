@extends('layouts.app', ['title' => 'Blog Post'])

@section('content')

    <main id= "conteudos" tabindex="0" class="container w-100 px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">

        @if (@isset($_GET['CreateBlog']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Successo!</strong> Post do Blog criado! :D
            </div>
        @endif

        @if (@isset($_GET['UpdateBlog']))
            <div class="alert alert-success alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Successo!</strong> Post do Blog atualizado! :D
            </div>
        @endif
        <a href="/blog" class="go-back"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Voltar</a>

        <div class="row mb-4">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <img src="{{ url('storage/images/' . $post->image_path) }}" alt="{{ $post->image_path }}" srcset=""
                    class=" blog-post-image">
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12  d-none d-sm-block">
                <div class="h-100 p-2 align-items-center align-middle card justify-content-center gap-5 py-5 "
                    id="author-info">

                    <div class="d-flex flex-column justify-content-center align-items-center gap-1">
                        <p class="author-name">{{ $post->author }}</p>
                        <p class="author-role">Autor(a)</p>
                    </div>

                    <div class="d-flex justify-content-start align-items-start gap-3 flex-column">
                        @foreach ($categories as $category)
                            <p class="category-name text-secondary px-5 fs-5 d-flex align-items-center gap-3"><i
                                    class="fas {{ $category->icon_label }}"></i> {{ $category->name }}</p>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="w-100 row">
            <div class="col-lg-9 col-md-9 col-sm-12 bg-white">
                <h1 class="blog-post-title fs-2 mt-0">{{ $post->title }}</h1>

                <div class="container d-flex flex-column flex-md-row justify-content-between py-2 px-0">
                    <!-- Data, categoria -->
                    <li class="list-inline-item blog-post-category">
                        {{ $post->publication_date->locale('pt')->timezone('Europe/Lisbon')->isoFormat('D MMMM, YYYY | H:mm') }}
                    </li>
                </div>

                <!-- Conteudo -->
                <div class="container px-0 py-2">
                    <p class="lh-base">
                        {{ $post->content }}
                    </p>
                </div>



                @if (Auth::check())
                    <div class="w-100">
                        <div class="d-flex flex-row gap-2">
                            <div class="card w-100 p-3">
                                <div class="d-flex flex-row gap-2 justify-content-start align-items-center mb-2">
                                    <img class="rounded-circle" src="{{ Auth::user()->getAdminAvatar() }}"
                                        alt="{{ Auth::user()->image_path }}" height="40" width="40">
                                    <span
                                        class="fw-bold">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                                </div>
                                <form class="add-comment" onsubmit="addComment(event)"
                                    blog-post-id="{{ $post->blog_post_id }}">
                                    <input type="text" class="form-control" placeholder="Escreve um comentário..."
                                        required="true">
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Comentários -->
                <div class="container px-0 py-2 d-grid gap-2" id="blog-post-comments">

                    @foreach ($comments as $comment)
                        @include('partials.blog.comment', ['comment' => $comment])
                    @endforeach

                </div>

            </div>
        </div>

        <script src="../js/app.js"></script>
        <script src="../js/blog/postComments.js"></script>
        <script src="../js/blog/editComments.js"></script>
        <script src="../js/blog/deleteComments.js"></script>
    </main>

@endsection
