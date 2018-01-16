<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
$loopCount = 0;
get_header(); ?>


<section class="wrapper style3">
    <div class="inner">
        <h1 class="major">Blog</h1>
    </div>
</section>
        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <?php $loopCount++; ?>
                <?php
                    $direction = 'alt';
                    $style = 'style2';
                    if ($loopCount % 2 == 0 ) {
                        $direction = '';
                        $style = 'style3';
                    }
                ?>
                <section class="wrapper <?php echo $direction; ?> <?php echo $style; ?>">
                <div class="inner">
                <article id="post-<?php the_ID(); ?>">

                    <header class="entry-header">
                        <?php
                            if ( is_single() ) :
                                the_title( '<h1 class="entry-title">', '</h1>' );
                            else :
                                the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                            endif;
                        ?>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php
                            /* translators: %s: Name of current post */
                            the_content( sprintf(
                                __( 'Continue reading %s', 'twentyfifteen' ),
                                the_title( '<span class="screen-reader-text">', '</span>', false )
                            ) );

                            wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
                                'separator'   => '<span class="screen-reader-text">, </span>',
                            ) );
                        ?>
                    </div><!-- .entry-content -->

                    <?php
                        // Author bio.
                        if ( is_single() && get_the_author_meta( 'description' ) ) :
//                            get_template_part( 'author-bio' );
                        endif;
                    ?>

                </article><!-- #post-## -->
                </div>
                </section>

            <?php endwhile; ?>
            <section class="wrapper">
                <div class="inner">

            <?php // Previous/next page navigation.
            the_posts_pagination( array(
                'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
                'next_text'          => __( 'Next page', 'twentyfifteen' ),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
            ) ); ?>

            </div>
            </section>


        <?php endif; ?>


<?php get_footer(); ?>

