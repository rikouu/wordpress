<?php get_header(); ?>
<div id="wrap">
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

					<h2><?php the_title(); ?></h2>
					<div class="post-meta">发表于：<?php the_date(); ?> | <?php if(get_the_tags($post->ID)) : ?>标签： <?php the_tags(__(' '), ' '); ?> |<?php endif;?> <?php if(function_exists('the_views')) the_views();?></div>
					<?php the_content(); ?>
			</div>
			<?php comments_template(); ?>
			<?php endwhile; endif; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>