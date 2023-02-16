<div class="services">
  <div class="services-container">
    @for($i = 0; $i < count($services); $i++)
      <a href="{!! $services[$i]['link'] !!}" class="services-block @if((($i+1) % 2) === 0) services-block__right @else services-block__left @endif"
         style="background-image: url('{!! $services[$i]['background'] !!}')">
        <div class="services-block-content">
          <div class="services-block-content-title">
              {!! $services[$i]['title'] !!}
          </div>
          <div class="services-block-content-text">
            {!! $services[$i]['subtitle'] !!}
          </div>
        </div>
      </a>
    @endfor
  </div>
</div>
