<?php get_header();?>
	<!-- Column 1 /Content -->
	<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>

	<div class="grid_8">
		<!-- Blog Post -->
		<div class="post">
			<!-- Post Title -->
			<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
</h3>
			<!-- Post Title -->
			<p class="sub"><?php the_tags('标签：', ', ', ''); ?>
&bull; <?php the_time('Y年n月j日') ?>
 &bull; <?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '评论已关闭'); ?><?php edit_post_link('编辑', ' &bull; ', ''); ?>
</p>
			<div class="hr dotted clearfix">&nbsp;</div>
			<!-- Post Title -->


			<!-- Post Content -->
			<?php the_content(); ?>

			<!-- Post Links -->

			<p class="clearfix"> <a href="<?php echo get_option('home'); ?>" class="button float" >&lt;&lt; 返回首页</a> <a href="#commentform" class="button float right" >发表评论</a> </p>

		</div>
		<div class="hr clearfix">&nbsp;</div>
			<?php comments_template(); ?>
		</div>
    <?php else : ?>
    <div class="errorbox">
        没有文章！
    </div>
    <?php endif; ?>
    <?php get_sidebar(); ?>

<?php get_footer(); ?>
