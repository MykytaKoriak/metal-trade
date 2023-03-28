<div class="header">
  <div class="header-container">
    <a href="{!! get_home_url() !!}" class="header-logo">
      <img src="{!! $logo !!}" alt="">
    </a>
    <div class="header-burger">

    </div>
  </div>
</div>
<div class="top-menu">
  <div class="top-menu-container">
    <div class="top-menu-links">
      <a href="{!! get_home_url() !!}" class="top-menu-links-item top-menu-links-item-logo">
        <img src="{!! $logo !!}" alt="">
      </a>
      @foreach($sitemap as $item)
        <a href="{!! $item['link'] !!}" class="top-menu-links-item">
          {!! $item['title'] !!}
        </a>
      @endforeach

    </div>
    <div class="top-menu-social">
      <div class="top-menu-social-list">
        @foreach($social_list as $item)
          <a href="{!! $item['url'] !!}" class="top-menu-social-list-item">
            <img src="{!! $item['icon'] !!}" alt="">
          </a>
        @endforeach
      </div>
      <div class="top-menu-social-phones">
        @foreach($phone_list as $item)
          <a rel="nofollow" href="tel:{!! $item['phone'] !!}" class="top-menu-social-phones-item">{!! $item['phone'] !!}</a>
        @endforeach
      </div>
    </div>
    <div class="top-menu-close">

    </div>
  </div>
</div>
<div class="fixed-header fixed-header__hidden">
  <a href="{!! get_home_url() !!}" class="fixed-header-logo">
    <img src="{!! $dark_logo !!}" alt="">
  </a>
  <div class="fixed-header-burger">

  </div>
</div>
