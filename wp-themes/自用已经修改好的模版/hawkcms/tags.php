<?php
/*
Template Name: Tags
*/
?>
<?php get_header(); ?>
<div id="wrap">
<div style="border-bottom:1px solid #e6e6e6;"><h2><?php the_title('',' &raquo;'); ?></h2></div>
<div style="padding-top: 10px;">

<?php while(have_posts()) : the_post(); ?>
	

	<?php $tags_list = get_tags('orderby=count&order=DESC');
	if ($tags_list) { 
		foreach($tags_list as $tag) {
			echo '<div  class="spantags"><a class="tag-a" href="'.get_tag_link($tag).'">'. mb_strimwidth(strip_tags($tag->name),0,20,'...') .'</a><span class="badge">'. $tag->count .'</span></div>'; 
			
		} 
	} 
	?>
<?php endwhile; ?>
</div>
</div>
<?php get_footer(); ?>