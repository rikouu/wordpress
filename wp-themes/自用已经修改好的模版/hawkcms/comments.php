<?php
	if ( post_password_required() ) : ?>
	<p><?php _e('输入密码以查看评论'); ?></p>
<?php return; endif; ?>

<div class="vl"></div>
<?php if ( $comments ) : ?>
	<ol class="comment_list">
		<?php wp_list_comments( array ('avatar_size'=>48,'type'=>'comment'));?>
	</ol>
	<div class="navigation">
        <span class="alignleft"><?php previous_comments_link('&laquo; 上一页') ?></span>
        <span class="alignright"><?php next_comments_link('下一页 &raquo;') ?></span>
    </div>
	<?php else : // If there are no comments yet ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>


	<div id="respond">
		<h3 id="post_comment"><?php comment_form_title( '发表评论 &raquo;', 'Leave a Reply to %s' ); ?></h3>
		<div id="cancel_comment_reply"><?php cancel_comment_reply_link() ?></div>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
			<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
		<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" name="commentform">
			<?php if ( $user_ID ) : ?>
			<p><textarea name="comment" id="comment" rows="5" tabindex="4"></textarea></p>

				<p><?php printf(__('Logged in as %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account') ?>"><?php _e('Log out &raquo;'); ?></a></p>
			<?php else : ?>
			<div class="input-prepend">
			  <span class="add-on">昵称</span>
			  <input class="spantags"  name="author" id="author" value="<?php echo $comment_author; ?>"  type="text" placeholder="昵称">
			</div><br />
			<div class="input-prepend">
			  <span class="add-on">邮箱</span>
			  <input class="spantags"  name="email" id="email" value="<?php echo $comment_author_email; ?>"  type="text" placeholder="邮箱">
			</div><br />
			<div class="input-prepend">
			  <span class="add-on">网址</span>
			  <input class="spantags"  name="url" id="url" value="<?php echo $comment_author_url; ?>" type="text" placeholder="昵称">
			</div>

			<p><textarea name="comment" id="comment" rows="5" tabindex="4"></textarea></p>
			<?php endif; ?>
		<p>	<button type="submit" class="btn btn-large"><?php echo attribute_escape(__('发表评论(Ctrl+Enter)')); ?></button></p>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
		<?php endif; // If registration required and not logged in ?>
		<script type="text/javascript">
			<!--//--><![CDATA[//><!--
			var commenttextarea = document.getElementById('comment');
			commenttextarea.onkeydown = function quickSubmit(e) {
			if (!e) var e = window.event;
			if (e.ctrlKey && e.keyCode == 13){
			document.getElementById('submit').click();
			}
			};
			//--><!]]>
		</script>
	</div>


	<?php else : // Comments are closed ?>
	<p><?php _e('抱歉，评论被关闭'); ?></p>
<?php endif; ?>