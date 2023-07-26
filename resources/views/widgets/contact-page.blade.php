<div class="contact-page">
    <div class="contact-page-container">
        <div class="contact-page-map">
            {{--<div id="contact_page_map"></div>--}}
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
                        @switch($block['type_block'])
                            @case("phone")
                            <a href="tel:{!! $block['info_1'] !!}">
                                <div class="contact-page-info-blocks-el-text">
                                    {!! $block['info_1'] !!}
                                </div>
                            </a>
                            <a href="tel:{!! $block['info_2'] !!}">
                                <div class="contact-page-info-blocks-el-text">
                                    {!! $block['info_2'] !!}
                                </div>
                            </a>
                            @break
                            @case("email")
                            <a href="mailto:{!! $block['info_1'] !!}">
                                <div class="contact-page-info-blocks-el-text">
                                    {!! $block['info_1'] !!}
                                </div>
                            </a>
                            <a href="mailto:{!! $block['info_2'] !!}">
                                <div class="contact-page-info-blocks-el-text">
                                    {!! $block['info_2'] !!}
                                </div>
                            </a>
                            @break
                            @case("address")
                            <a href="https://www.google.com.ua/maps/search/{!! $block['info_2'] !!} {!! $block['info_1'] !!}/" target="_blank">
                                <div class="contact-page-info-blocks-el-text">
                                    {!! $block['info_1'] !!}
                                </div>
                                <div class="contact-page-info-blocks-el-text">
                                    {!! $block['info_2'] !!}
                                </div>
                            </a>
                            @break
                            @default
                            <div class="contact-page-info-blocks-el-text">
                                {!! $block['info_1'] !!}
                            </div>
                            <div class="contact-page-info-blocks-el-text">
                                {!! $block['info_2'] !!}
                            </div>
                            @break
                        @endswitch
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
