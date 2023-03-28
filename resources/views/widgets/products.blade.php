<div class="products">
  <div class="products-title">
    {{ $block_title }}
  </div>
  <div class="products-container">
    @foreach($products as $product)
      <div>
          <a href="{!! $product['link'] !!}" class="products-element"
             style="background-image: url('{!! $product['background'] !!}')">
              <div class="products-element-content">
                  <div class="products-element-content-title">
                      {!! $product['title'] !!}
                  </div>
              </div>
          </a>
      </div>
    @endforeach
  </div>
</div>
