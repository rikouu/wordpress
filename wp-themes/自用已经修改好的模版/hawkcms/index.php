<?php get_header(); ?>
<div id="wrap">
	<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="media">
              
			  <div class="media-body">

                <h2 class="media-heading"><?php the_time('Y-m-d');?>&nbsp;&nbsp;<a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h2>
             </div>
       </div>

	<?php endwhile; else: ?>
		<?php endif; ?>

			<div class="nav-previous"><?php next_posts_link(__('旧文章')) ?></div>
			<div class="nav-next"><?php previous_posts_link(__('新文章')) ?></div><br>
	</div>
	<?php get_sidebar(); ?> 
</div>
<?php get_footer(); ?>