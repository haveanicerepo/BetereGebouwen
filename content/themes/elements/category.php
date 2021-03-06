<?php
get_header();

$post_about = get_field('post_about', 'option');
if ($post_about) {
    $post_about_id = $post_about[0]->ID;
}

if(!have_posts()):
    include 'content-none.php';
endif;
?>

<?php
// Featured post
$post_featured = new WP_Query( array(
    'posts_per_page' => 1,
    'cat' => $wp_query->get_queried_object_id(),
    'ignore_sticky_posts' => true,
    'post__not_in' => array($post_about_id)
) );

if ($post_featured->have_posts()) :
?>
    <section class="section section--bg">
        <div class="container">
            <div class="row">
                <?php
                while ($post_featured->have_posts()) : $post_featured->the_post();
                    include 'content-post-featured.php';
                    break;
                endwhile;
                ?>
            </div>
        </div>

        <?php
        $post_semi_max = 3;
        if ($post_about) {
            $post_semi_max = 2;
        }
        $post_semi = new WP_Query( array(
            'posts_per_page' => $post_semi_max,
            'cat' => $wp_query->get_queried_object_id(),
            'offset' => 1,
            'ignore_sticky_posts' => true,
            'post__not_in' => array($post_about_id)
        ) );

        if ($post_semi->have_posts()) :
            ?>
            <div class="container">
                <div class="row">
                    <ul class="grid">
                        <?php
                        while ($post_semi->have_posts()) : $post_semi->the_post();
                            include 'content-post-grid.php';
                        endwhile;

                        if ($post_about) {
                            include 'content-post-about.php';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php
// List w/ posts
$posts_offset = 4;
if ($post_about) {
    $posts_offset = 3;
}
$posts = new WP_Query( array(
    'posts_per_page' => 10,
    'cat' => $wp_query->get_queried_object_id(),
    'offset' => $posts_offset,
    'ignore_sticky_posts' => true,
    'post__not_in' => array($post_about_id)
) );

if ($posts->have_posts()) :
    ?>
    <section class="section">
        <div class="container">
            <div class="section__header row">
                <div class="col-md-12">
                    <h2>Meer artikelen</h2>
                </div>
            </div>

            <div class="row">
                <div class="list--posts col-md-12">
                    <?php
                    while ($posts->have_posts()) : $posts->the_post();
                        include 'content-post-list.php';
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php
endif;

get_footer();
?>