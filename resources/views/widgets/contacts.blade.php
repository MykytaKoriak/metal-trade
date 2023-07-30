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
    @if($map_id != " ")

        <div class="contact-map">
            <div class="class-map-object" id="{!! $map_id !!}"></div>
        </div>
    @endif
</div>
