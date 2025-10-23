<div class="contact">
  <div class="contact-content">
    <div class="contact-content-info">
      <div class="contact-content-info-title">
        {!! $title !!}
      </div>
      @if($map_id != " ")
        <div class="contact-content-info-mobile-map">
          <div class="class-map-object" id="{!! $map_id !!}-mobile"></div>
        </div>
      @endif
      @foreach($address_list as $address)
        <div class="contact-content-info-address">
          {!! $address['address'] !!}
        </div>
      @endforeach
      @foreach($email_list as $email)
        <a href="mailto:{!! $email['email'] !!}" class="contact-content-info-email">
          {!! $email['email'] !!}
        </a>
      @endforeach
      @foreach($phone_list as $phone)
        <a href="tel:{!! $phone['phone'] !!}" class="contact-content-info-phone">
          {!! $phone['phone'] !!}
        </a>
      @endforeach
      <div class="contact-content-info-social">
        @foreach($social_list as $social)
          <a href="{!! $social['url'] !!}" class="contact-content-info-social-icon">
            <img src="{!! $social['icon'] !!}" alt="">
          </a>
        @endforeach
      </div>
    </div>
    <div class="contact-content-form">
      <div class="contact-content-form-title">
        {!! $mobile_form_title !!}
      </div>
      {!! do_shortcode($form) !!}
    </div>
  </div>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <div id="contact_page_map" style="height:400px;"></div>

  <script>
    const map = L.map('contact_page_map').setView([48.519712, 32.274394], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const marker = L.marker([48.5143787, 32.2540343]).addTo(map);
    marker.bindPopup(`
    <b> {{ $map_title }} </b><br>
    {!! $map_content !!}
  `).openPopup();
  </script>
</div>
