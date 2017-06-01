<?php
/*
Template Name: Artives
*/
?>
<?php get_header(); ?>
<div id="wrap">
	<?php while(have_posts()) : the_post(); ?>
		<div style="float:left;margin: 10px;"><h3><?php the_title('',' &raquo;'); ?></h3></div>
		<div id="page_content"><?php archives_list_SHe(); ?></div>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>