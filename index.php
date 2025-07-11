<!-- form -->
<?php
    $from_message = "";
    $from_error = "";

    if($_SERVER["REQUEST_METHOD"] === "POST" &&
        isset($_POST["cf_submitted"]) &&
        wp_verify_nonce($_POST["cf_nonce_field"], "cf_nonce_action")
    ){
        $name = sanitize_text_field($_POST["cf_name"]);
        $email = sanitize_email($_POST["cf_email"]);
        $message = sanitize_textarea_field($_POST["cf_message"]);

        if(empty($name) || empty($email) || empty($message)) {
            $form_error = "すべての項目を入力してください。";
        } elseif(!is_email($email)) {
            $form_error = "有効なメールアドレスを入力してください。";
        } else {
            $to = get_option("admin_email");
            $subject = "お問い合わせが届きました";
            $headers = [
                "Content-Type: text/plain; charset=UTF-8",
                "From $name <$email>"
            ];
            $body = "名前: $name\nメール: $email\n\nメッセージ:\n$message";
            if(wp_mail($to, $subject, $body, $headers)) {
                $from_message = "送信が完了しました、ありがとうございます。";
            } else {
                $form_error = "送信に失敗しました。時間を置いて再度お試しください。";
                }
            }
        }
?>


<!-- header -->
<?php get_header(); ?>


<!-- main visual -->
<main class="l-main">
    <div class="c-main-visual" id="js-main-visual">
        <h2 class="c-main-visual__title">
            Web Portfolio
        </h2>
    </div>
    <!-- work -->
    <section class="p-work" id="p-work">
        <div class="p-work__inner">
            <div class="p-work__title-wrap">
                <h2 class="p-work__title-text">
                    Work
                </h2>
            </div>
            <div class="p-work__content-wrap">
                <div class="p-work__content">
                    <?php if (have_posts()) : ?>
                        <ul class="p-work__list" id="js-work">
                            <?php while (have_posts()) : the_post(); ?>
                                <li class="p-work__item js-item">
                                    <a href="<?php the_field("url")?>" class="p-work__item-link">
                                        <?php the_post_thumbnail("", ["class" => "p-work__item-img"]);?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="p-work__show">
                    <a href="<?php echo esc_url(get_category_link(get_category_by_slug('work'))); ?>" class="p-work__show-link">
                        { view work }
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- about -->
    <section class="p-about" id="p-about">
        <div class="p-about__inner">
            <div class="p-about__title-wrap">
                <h2 class="p-about__title-text">
                    About
                </h2>
            </div>
            <div class="p-about__detail-wrap">
                <dl class="p-about__detail-list">
                    <dt class="p-about__detail-heading">
                        生年月日：
                    </dt>
                    <dd class="p-about__detail-description">
                        1987年01月14日
                    </dd>
                    <dt class="p-about__detail-heading">
                        趣味・特技：
                    </dt>
                    <dd class="p-about__detail-description">
                        映画鑑賞、Python、ダイエット、ゲーム
                    </dd>
                    <dt class="p-about__detail-heading">
                        目標：
                    </dt>
                    <dd class="p-about__detail-description">
                        フロントエンドエンジニア、Web制作、Webコーダー、Webエンジニア
                    </dd>
                    <dt class="p-about__detail-heading">
                        スキル：
                    </dt>
                    <dd class="p-about__detail-description">
                        <img class="p-about__detail-skill" src="<?php echo esc_url(get_theme_file_uri("./img/top/html5.svg"))?>">
                        <img class="p-about__detail-skill" src="<?php echo esc_url(get_theme_file_uri("./img/top/css.svg"))?>">
                        <img class="p-about__detail-skill" src="<?php echo esc_url(get_theme_file_uri("./img/top/sass.svg"))?>">
                        <img class="p-about__detail-skill" src="<?php echo esc_url(get_theme_file_uri("./img/top/javascript.svg"))?>">
                        <img class="p-about__detail-skill" src="<?php echo esc_url(get_theme_file_uri("./img/top/wordpress.svg"))?>">
                        <img class="p-about__detail-skill" src="<?php echo esc_url(get_theme_file_uri("./img/top/python.svg"))?>">
                        <img class="p-about__detail-skill" src="<?php echo esc_url(get_theme_file_uri("./img/top/figma.svg"))?>">
                    </dd>
                    <dt class="p-about__detail-heading">
                        自己紹介：
                    </dt>
                    <dd class="p-about__detail-description">
                        自分の書いたプログラムが、画面上で「動き」として表現されることに魅力を感じ、フロントエンドを中心に学習しています。<br>
                        一度Web業界への転職に挑戦するも思うようにいかず、悔しさを抱えて離れた時期もありましたが、2025年6月から改めてWebの世界に戻り学び直しています。<br>
                        現在は模写やオリジナルサイトの制作を通して、実践的なスキルを日々磨いています。<br>
                        今後は実案件にも積極的に取り組み、見る人の心を動かすような、表現力のあるWebサイトを作れるエンジニアを目指しています。
                    </dd>
                </dl>
            </div>
        </div>
    </section>
    <!-- contact -->
    <section class="p-contact" id="p-contact">
        <div class="p-contact__inner">
            <div class="p-contact__title-wrap">
                <h2 class="p-contact__title-text">
                    Contact
                </h2>
            </div>
            <div class="p-contact__description-wrap">
                <p class="p-contact__description-text">
                    Web制作やお仕事のご依頼・ご相談などがありましたら、以下のフォームからお気軽にご連絡ください。<br>
                    数日以内にご返信させていただきます。
                </p>
            </div>
            <!-- contact form area -->
            <div class="p-contact__content">
                <?php if(!empty($form_message)) :?>
                    <p calss="p-contact__success">
                        <?php echo esc_html($form_message); ?>
                    </p>
                <?php elseif(!empty($form_error)) :?>
                    <p class="p-contact__error">
                        <?php echo esc_html($form_error); ?>
                    </p>
                <?php endif; ?>

                <form action="<?php echo esc_url($_SERVER["REQUEST_URI"]); ?>" method="post" class="p-contact__form">
                    <?php wp_nonce_field("cf_nonce_action", "cf_nonce_field"); ?>
                    <p>
                        <label for="cf_name">Name</label><br>
                        <input type="text" id="cf_name" name="cf_name">
                    </p>
                    <p>
                        <label for="cf_email">Mail</label><br>
                        <input type="email" id="cf_email" name="cf_email">
                    </p>
                    <p>
                        <label for="cf_message">Message</label><br>
                        <textarea name="cf_message" id="cf_message"></textarea>
                    </p>
                    <p>
                        <input type="hidden" name="cf_submitted" value="1">
                        <input type="submit" value="Send" class="p-contact__submit">
                    </p>
                </form>
            </div>
            <!-- contact form  area end-->
        </div>
    </section>
</main>


<!-- footer -->
<?php get_footer(); ?>