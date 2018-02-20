<?php get_header(); ?>



<?php if (have_posts()) : ?>
    <section class="wrapper style2">
        <div class="inner" id="blogContainer">
            <div class="blogWrapper">
                <h1 class="major">Packet<sup>39</sup> Blog</h1>
            <?php while (have_posts()) : the_post(); ?>
                <article class="postWrapper" id="post-<?php the_ID(); ?>">

                    <header class="entry-header">
                        <?php
                            the_post_thumbnail();
                            the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');

                        ?>
                        <span>- <?php the_date(); ?></span>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div><!-- .entry-content -->

                <hr>
                </article><!-- #post-## -->


            <?php endwhile; ?>
            </div>
            <?php if ( is_active_sidebar( 'article-sidebar' ) ) : ?>
            <aside class="sidebarWrapper">
                <?php dynamic_sidebar( 'article-sidebar' ); ?>
            </aside>
            <?php endif; ?>
        </div>
    </section>
    <nav id="pagination" class="wrapper style3 alt">
        <div class="inner align-center">

            <?php // Previous/next page navigation.
            the_posts_pagination(array(
                'prev_text' => __('< Previous Page', 'twentyfifteen'),
                'next_text' => __('Next Page >', 'twentyfifteen'),
                'mid_size' => 3,
                'screen_reader_text' => 'Read More Posts'
            )); ?>

        </div>
    </nav>


<?php endif; ?>


<?php get_footer(); ?>

