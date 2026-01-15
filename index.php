<?php
/**
 * Template par défaut
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <p>Aucun contenu trouvé.</p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>