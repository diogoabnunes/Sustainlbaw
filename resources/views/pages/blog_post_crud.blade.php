@extends('layouts.app', ['title' => 'Blog Post'])

@section('content')

    <main id="conteudos" tabindex="0"
        class="container w-100 px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">

        <a href="/blog" class="go-back"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Voltar</a>
        @if (@isset($_GET['error']))
            <div class="alert alert-danger alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Não foi possível criar o blog post...</strong> Tenta novamente.
            </div>
        @endif

        @if (@isset($_GET['errorEdit']))
            <div class="alert alert-danger alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Erro...</strong> Insere uma imagem.
            </div>
        @endif
        @if (@isset($post))
            <form method="post" action="{{ '/blog/' . $post->blog_post_id }}" id="blog_post_crud"
                class="form-page-new w-100" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
            @else
                <form method="post" action="/blog" id="blog_post_crud" class="form-page-new w-100"
                    enctype="multipart/form-data">
        @endif

        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                @if (@isset($post))
                    <h1 class="pb-2">Editar publicação</h1>
                @else
                    <h1 class="pb-2">Adicionar uma publicação</h1>
                @endif
                <div class="mb-3">
                    @if ($errors->has('title'))
                        <div class="alert alert-danger alert-dismissible">
                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            Erro no título. :(
                        </div>
                    @endif
                    <label for="title" class="form-label">Título</label>
                    <label class="text-danger">*</label>
                    <input type="text" name="title" value="{{ $post->title ?? '' }}" class="form-control" id="title"
                        aria-describedby="title" required>
                </div>
                <div class="mb-3">
                    @if ($errors->has('author'))
                        <div class="alert alert-danger alert-dismissible">
                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            Erro no autor. :(
                        </div>
                    @endif

                    <label for="author" class="form-label">Autor</label>
                    <label class="text-danger">*</label>
                    <input type="text" name="author" value="{{ $post->author ?? '' }}" class="form-control" id="author"
                        aria-describedby="author" required>
                </div>

                <p class="font-weight-bold">Categorias</p>

                <!-- Basic dropdown -->
                <button class="btn btn-primary dropdown-toggle mr-4 mb-4" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Categorias</button>
                <div class="dropdown-menu">


                    @foreach ($blog_categories as $category)
                        <a class="dropdown-item">
                            <!-- Default unchecked -->
                            <div class="custom-control custom-checkbox required">
                                @if ($category->name == 'Outro')
                                    <input type="checkbox" name="categories[]" value="{{ $category->category_id }}"
                                        class="custom-control-input" id="{{ 'category_' . $category->category_id }}"
                                        checked>
                                @elseif ($category->found == true)
                                    <input type="checkbox" name="categories[]" value="{{ $category->category_id }}"
                                        class="custom-control-input" id="{{ 'category_' . $category->category_id }}"
                                        checked>
                                @else
                                    <input type="checkbox" name="categories[]" value="{{ $category->category_id }}"
                                        class="custom-control-input" id="{{ 'category_' . $category->category_id }}">
                                @endif
                                <label class="custom-control-label" for="checkbox1">{{ $category->name }}</label>
                            </div>
                        </a>
                    @endforeach

                </div>
            </div>

            <div class="imageCol col-lg-6 col-md-6 col-xs-12">
                <div class="image">
                    @if ($errors->has('image_path'))
                        <div class="alert alert-danger alert-dismissible">
                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            Adiciona uma fotografia.
                        </div>
                    @endif
                    @if (@isset($post))
                        <label id="upload-label" for="upload-photo"><i id="camera-icon"></i>
                            <input type="file" name="image_path" value="{{ $post->image_path ?? '' }}" id="upload-photo"
                                action=style="display:none" onchange="loadFile(event)" />
                            <img id="display-photo" src="{{ url('storage/images/' . $post->image_path) }}"
                                alt="{{ $post->image_path }}">
                        @else
                            <label id="upload-label" for="upload-photo"><i id="camera-icon" class="fas fa-camera"></i>
                                <input type="file" name="image_path" value="{{ $post->image_path ?? '' }}"
                                    id="upload-photo" action=style="display:none" onchange="loadFile(event)" />
                                <img id="display-photo" src="" alt="Photo input" style="display:none;">
                    @endif
                    </label>
                </div>

                <script>
                    var loadFile = function(event) {
                        let output = document.getElementById('display-photo');
                        output.style.display = "block";
                        output.src = URL.createObjectURL(event.target.files[0]);
                        let camera = document.getElementById('camera-icon');
                        camera.style.display = "none";
                    };

                </script>
            </div>
        </div>


        <div class="mb-3">
            @if ($errors->has('content'))
                <div class="alert alert-danger alert-dismissible">
                    <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    Erro no texto do blog. :(
                </div>
            @endif
            <label for="exampleFormControlTextarea1" class="form-label">Texto:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="content"
                rows="10">{{ $post->content ?? '' }}</textarea>
        </div>
        @if (@isset($post))
            <button type="submit" class="btn btn-primary">Editar</button>
        @else
            <button type="submit" class="btn btn-primary">Adicionar</button>
        @endif

        </form>

    </main>

@endsection
