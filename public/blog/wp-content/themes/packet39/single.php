<?php get_header(); ?>


<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>
        <section class="wrapper style2 alt">
            <div class="inner" id="blogContainer">
                <article id="post-<?php the_ID(); ?>">

                    <header class="entry-header">
                        <?php the_title('<h1 class="major">', '</h1>'); ?>
                        <?php
                        the_post_thumbnail();
                        ?>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php
                        /* translators: %s: Name of current post */
                        the_content(sprintf(
                            __('Continue reading %s', 'twentyfifteen'),
                            the_title('<span class="screen-reader-text">', '</span>', false)
                        ));

                        ?>
                    </div><!-- .entry-content -->
                    <footer class="align-center">
                            <h2 class="author-heading"><?php _e( 'Written by', 'twentyfifteen' ); ?></h2>
                            <div class="author-avatar">
                                <?php
                                /**
                                 * Filter the author bio avatar size.
                                 *
                                 * @since Twenty Fifteen 1.0
                                 *
                                 * @param int $size The avatar height and width size in pixels.
                                 */
                                $author_bio_avatar_size = apply_filters( 'twentyfifteen_author_bio_avatar_size', 56 );

                                echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
                                ?>
                            </div><!-- .author-avatar -->

                            <div class="author-description">
                                <h3 class="author-title"><?php echo get_the_author(); ?></h3>

                                <p class="author-bio">
                                    <?php the_author_meta( 'description' ); ?>
                                    <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                        <?php printf( __( 'View all posts by %s', 'twentyfifteen' ), get_the_author() ); ?>
                                    </a>
                                </p><!-- .author-bio -->

                            </div><!-- .author-description -->

                    </footer>

                </article><!-- #post-## -->
            </div>
        </section>

    <?php endwhile; ?>
    <div class="wrapper">
        <div class="inner align-center">

            <?php previous_post_link('&laquo; %link |', 'Previous Post', 'yes'); ?>
            <a href="<?php echo get_home_url(); ?>" title="Blog Home">Blog Home</a> <?php next_post_link('| %link &raquo;', 'Next Post', 'yes'); ?>

        </div>
    </div>

<?php endif; ?>


<?php get_footer(); ?>

