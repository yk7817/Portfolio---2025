<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ; ?>
</head>
<body>
    <div class="l-container">
    <video class="c-container__video" src="<?php echo esc_url(get_theme_file_uri("./video/3129977-uhd_3840_2160_30fps.mp4")); ?>" autoplay muted loop playsinline ></video>
        <header class="l-header">
            <div class="c-header__inner">
                <h1 class="c-header__title">
                    <a href="<?php echo esc_url(home_url()); ?>" class="c-header__title-link">Y.K</a>
                </h1>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-navigation',
                        'container' => 'nav',
                        'container_class' => 'c-header__menu',
                        'menu_class' => 'c-header__menu-list',
                        'menu_id' => "js-header-menu",
                        ))
                ?>
            </div>
        </header>
