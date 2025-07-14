<!-- header -->
<?php get_header(); ?>

<!-- cotegory -->
<main class="p-category">
    <div class="p-category__inner">
        <div class="p-category__title">
            <h2 class="p-category__title-text">
                <?php
                    $categories = get_the_category();
                    if(!empty($categories)){
                        foreach($categories as $category){
                            if($category->slug === "work") {
                                echo $category -> name;
                            }
                        }
                    }
                ?>
            </h2>
        </div>
        <?php if(have_posts()) : ?>
            <div class="p-category__work-wrap">
                <ul class="p-category__work-list">
                    <?php while(have_posts()) : the_post(); ?>
                        <li class="p-category__work-item">
                            <a href="<?php the_field("url");?>" target="_blank" class="p-category__work-link">
                                <?php the_post_thumbnail("full", ["class" => "p-category__work-img"]); ?>
                            </a>
                            <h3 class="p-category__work-title"><?php the_field("title_name");?></h3>
                            <h4 class="p-category__work-workarea"><?php the_field("work_area");?></h4>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endif; ?>
        <!-- pagination -->
        <?php custom_pagination(); ?>
    </div>
</main>


<!-- footer -->
<?php get_footer(); ?>