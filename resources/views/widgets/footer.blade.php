<footer id="footer" class="footer">
  <div class="footer-container">
    <div class="footer-content">
      <div class="footer-content-tagline">
        {!! $title !!}
      </div>
      <div class="footer-content-map">
        <div class="footer-content-map-title">
          {!! $sitemap_title !!}
        </div>
        <div class="footer-content-map-list">
          @foreach($sitemap as $item)
            <div class="footer-content-map-list-item">
              <a href="{!! $item['link'] !!}" class="footer-content-map-list-item-link">
                {!! $item['title'] !!}
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="footer-contacts">
      <div class="footer-contacts-person">
        @foreach($phone_list as $item)
          <a href="tel:{!! $item['phone'] !!}" class="footer-contacts-person-phone">
            {!! $item['phone'] !!}
          </a>
        @endforeach
        @foreach($email_list as $item)
          <a href="mailto:{!! $item['email'] !!}" class="footer-contacts-person-email">
              {!! $item['email'] !!}
          </a>
        @endforeach
      </div>
      <div class="footer-contacts-social">
        <div class="footer-contacts-social-title">
          {!! $social_title !!}
        </div>
        <div class="footer-contacts-social-list">
          @foreach($social_list as $item)
            <a href="{!! $item['social'] !!}" class="footer-contacts-social-list-item">{!! $item['text'] !!}</a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</footer>
