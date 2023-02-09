<!DOCTYPE html>

<?php if (is_user_logged_in()) { ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" class="wpadmin-logged-in">
<?php } else { ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<?php } ?>

<?php include('header.php'); ?>

<body>
<div class="header">
    <div class="header-container">
        <a href="" class="header-logo">
            <!--            <img src="" alt="">-->
        </a>
        <div class="header-burger">

        </div>
    </div>
</div>

<div class="fixed-header fixed-header__hidden">
    <a href="" class="fixed-header-logo">
        <!--            <img src="" alt="">-->
    </a>
    <div class="fixed-header-burger">

    </div>
</div>

<div id="banner" class="banner">
    <div class="banner-container">
        <div class="banner-container-tagline">
            Робимо якісно і надійно
        </div>
    </div>
</div>
<div class="tagline">
    <div class="tagline-container">
        <div class="tagline-text">
            <span style="text-align: center">МИ РОЗУМНО</span>
            <span style="text-align: left">ПІДХОДИМО</span>
            <span style="text-align: right">ДО ОРГАНІЗАЦІЇ</span>
            <span style="text-align: left">ВАШОГО ПРОСТОРУ</span>
        </div>
    </div>
</div>
<div class="services">
    <div class="services-container">
        <a href="#" class="services-block services-block__right"  style="background-image: url('https://kosmomachine.com/wp-content/uploads/2017/09/KOS_interior-panoramic-1200x445.jpg')">
            <div class="services-block-content">
                <div class="services-block-content-title">
                    ТОРГОВЕЛЬНЕ ОБЛАДНАННЯ
                </div>
                <div class="services-block-content-text">
                    Ми поставляємо торговельне обладнання відомих брендів та створюємо власне обладнання для потреб клієнтів
                </div>
            </div>
        </a>
        <a href="#"  class="services-block services-block__left"  style="background-image: url('https://kosmomachine.com/wp-content/uploads/2017/09/KOS_interior-panoramic-1200x445.jpg')">
            <div class="services-block-content">
                <div class="services-block-content-title">
                    ТОРГОВЕЛЬНЕ ОБЛАДНАННЯ
                </div>
                <div class="services-block-content-text">
                    Ми поставляємо торговельне обладнання відомих брендів та створюємо власне обладнання для потреб клієнтів
                </div>
            </div>
        </a>
        <a href="#"  class="services-block services-block__right"  style="background-image: url('https://kosmomachine.com/wp-content/uploads/2017/09/KOS_interior-panoramic-1200x445.jpg')">
            <div class="services-block-content">
                <div class="services-block-content-title">
                    ТОРГОВЕЛЬНЕ ОБЛАДНАННЯ
                </div>
                <div class="services-block-content-text">
                    Ми поставляємо торговельне обладнання відомих брендів та створюємо власне обладнання для потреб клієнтів
                </div>
            </div>
        </a>
    </div>
</div>



<div class="footer"></div>
<?php include('footer.php'); ?>

</body>

</html>