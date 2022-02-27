<section id="categories">
    <div class="d-flex justify-content-between">
        <h3 class="col align-self-center">Categorias</h3>
    </div>
    <div class="row">

        @foreach ($categories as $category)
            <a href="{{ '/all_events/' . $category->category_id }}"
                class="category-card col-sm-6 col-lg-3 col-xl-3 col-md-6 col-xs-12">
                <img class="img-fluid" src="../assets/{{ $category->image_path }}"
                    alt="{{ $category->image_path }}" />
                <div class="textCateg">
                    <h2>{{ $category->name }}</h2>
                </div>
            </a>
        @endforeach
    </div>
</section>
