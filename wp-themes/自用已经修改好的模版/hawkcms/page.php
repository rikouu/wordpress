<?php get_header(); ?>
<div id="wrap">
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<h1><?php the_title();?></h1>
				<div style="clear:both"></div>
				<div class="content" style="float:left;">
					<?php the_content(); ?>
				</div>
			</div>
			<?php comments_template(); ?>
			<?php endwhile;endif; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>