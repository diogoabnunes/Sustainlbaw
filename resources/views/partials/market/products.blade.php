<section id="products">
    <div class="row">
        @foreach ($products as $product)
            <div class="product-card col-sm-6 col-lg-3 col-md-6 col-xs-12">
                <img class="img-fluid" src="{{ url('storage/images/' . $product->image_path) }}"
                    alt="{{ $product->image_path }}" />
                <h3>{{ $product->name }}</h3>
            </div>
        @endforeach
    </div>

</section>
