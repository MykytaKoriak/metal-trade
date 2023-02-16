<div class="products">
  <div class="products-container">
    @foreach($products as $product)
    <a href="{!! $product['link'] !!}" class="products-element"
         style="background-image: url('{!! $product['background'] !!}')">
      <div class="products-element-content">
        <div class="products-element-content-title">
            {!! $product['title'] !!}
        </div>
      </div>
    </a>
    @endforeach
  </div>
</div>
