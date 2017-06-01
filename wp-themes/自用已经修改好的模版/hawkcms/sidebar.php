<div id="sidebar">
	<ul>
		<?php if(is_home() || is_front_page()) {?>

		<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_homesidebar')){} ?>
		<?php } else {?>
		<li><h2>最新日志</h2>
			<?php 
				$args = array(
					'order'   => DESC,		    
					'caller_get_posts' => 1,
					'paged' => $paged,
					'showposts'=>10
				);
				query_posts($args);		
		?>
			<ul>
				<?php while (have_posts()) : the_post(); ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile;?>
			</ul>
		</li>

		<?php }?>
		<li><h2>标签云</h2>
			<div class="tags">
				<?php wp_tag_cloud('unit=px&smallest=12&largest=20'); ?>
			</div>
		</li>
	</ul>
</div>
