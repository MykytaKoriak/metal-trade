<div class="contact-page">
  <div class="contact-page-container">
    <div class="contact-page-map">
      {!! do_shortcode($map) !!}
    </div>
    <div class="contact-page-info">
      <div class="contact-page-info-title">
        {!! $title !!}
      </div>
      <div class="contact-page-info-blocks">
        @foreach($contact_blocks as $block)
          <div class="contact-page-info-blocks-el">
            <div class="contact-page-info-blocks-el-title">
                {!! $block['title'] !!}
            </div>
            <div class="contact-page-info-blocks-el-text">
              {!! $block['info_1'] !!}
            </div>
            <div class="contact-page-info-blocks-el-text">
              {!! $block['info_2'] !!}
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="contact-page-container">
    <div class="contact-page-mail">
      <div class="contact-page-mail-social">
        <div class="contact-page-mail-social-title">
            {!! $join_title !!}
        </div>
        <div class="contact-page-mail-social-links">
          @foreach($social_list as $block)
          <a href="{!! $block['url'] !!}" class="contact-page-mail-social-links-el">
            <img src="{!! $block['icon'] !!}" alt="">
          </a>
          @endforeach
        </div>
      </div>
      <div class="contact-page-mail-button">
          {!! $button_text !!}
      </div>
      <div class="contact-page-mail-popup">
        <div class="contact-page-mail-popup-container">
          <div class="contact-page-mail-popup-close">
          </div>
          <div class="contact-page-mail-popup-title">
              {!! $popup_title !!}
          </div>
          <div class="contact-page-mail-popup-form">
            {!! do_shortcode($popup_form) !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
