<!-- header -->
<?php get_header(); ?>

<!-- single article -->
<main class="p-single-article">
    <article class="p-single-article__inner">
        <?php if(have_posts()) : ?>
            <?php while(have_posts()) : the_post(); ?>
                <div class="p-single-article__title">
                    <h2 class="p-single-article__title-text">
                        <?php echo the_title(); ?>
                    </h2>
                </div>
                <div class="p-single-article__content">
                    
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </article>
</main>

<!-- footer -->
<?php get_footer(); ?>