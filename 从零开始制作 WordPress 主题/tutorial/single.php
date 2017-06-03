<?php get_header();?>
<div id="container">
<?php if(have_posts()):?>
    <?php while(have_posts()):the_post();?>
        <div class="post" id="post-<?php the_ID(); ?>">
        <h2><a href="<?php the_permalink();?>"  title="<?php the_title(); ?>"><?php the_title();?></a></h2>
            <div class="entry">
                <?php the_content();?>
                <?php link_pages('<p><strong>Pages:</strong>', '</p>', 'number'); ?>
                <p class="postmetadata">
                    <?php _e('分类&#58;'); ?>&nbsp;
                    <?php the_category(',') ?> <?php _e('作者&#58;'); ?>&nbsp;
                    <?php  the_author(); ?>&nbsp;
                    <?php edit_post_link('编辑', ' &#124; ', ''); ?>
                </p>
            </div>
            <div class="comments-template">
                <?php comments_template(); ?>
            </div>
        </div>
    <?php endwhile;?>
    <div class="navigation">
        <?php previous_post_link('%link') ?> <?php next_post_link('%link') ?>
    </div>
<?php else : ?>
    <div class="post">
        <h2><?php _e('Not Found');?></h2>
    </div>
<?php endif;?>
</div>
<?php get_sidebar();?>
<?php get_footer();?>
