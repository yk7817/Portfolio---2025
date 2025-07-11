<?php

// テーマ追加設定
function theme_setup() {
    add_theme_support("post-thumbnails");
    add_theme_support("title-tag");
}
add_action("after_setup_theme", "theme_setup");


// CSS, JS 読み込み
function my_enqueue_scripts() {
    wp_enqueue_style("style", get_stylesheet_uri(), array("main_style"), "all");
    wp_enqueue_style("main_style", get_template_directory_uri().'/css/style.css', array(), "all");
    wp_enqueue_style("not_serif_jp", "https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap", array(), "all");
    wp_enqueue_script("gsap", "https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js", array(), "3.13.0", true);
    wp_enqueue_script('scrolltrigger', "https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/ScrollTrigger.min.js", array(), "3.13.0", true);
    wp_enqueue_script('draggable', "https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/Draggable.min.js", array(), "3.13.0", true);
    wp_enqueue_script("main_script", get_template_directory_uri().'/js/main.js', array(), null, true);
    wp_enqueue_script("pixi", "https://cdnjs.cloudflare.com/ajax/libs/pixi.js/8.6.6/pixi.min.js", array(), "8.6.6", true);
}
add_action("wp_enqueue_scripts", "my_enqueue_scripts");

// カスタムメニュー
function register_menus() {
    register_nav_menus(array(
        'header-navigation' => 'header',
        'footer-navigation' => 'footer',
    ));
}
add_action('after_setup_theme', 'register_menus');
