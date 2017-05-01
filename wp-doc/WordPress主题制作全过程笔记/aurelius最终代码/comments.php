<?php
    if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
?>

        <!-- Comment's List -->
        <h3>Comments</h3>
        <div class="hr dotted clearfix">&nbsp;</div>
        <ol class="commentlist">
    <?php
    if (!empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {
        // if there's a password
        // and it doesn't match the cookie
    ?>
    <li class="decmt-box">
        <p><a href="#addcomment">请输入密码再查看评论内容.</a></p>
    </li>
    <?php
        } else if ( !comments_open() ) {
    ?>
    <li class="decmt-box">
        <p><a href="#addcomment">评论功能已经关闭!</a></p>
    </li>
    <?php
        } else if ( !have_comments() ) {
    ?>
    <li class="decmt-box">
        <p><a href="#addcomment">还没有任何评论，你来说两句吧</a></p>
    </li>
    <?php
        } else {
            wp_list_comments('type=comment&callback=aurelius_comment');
        }
    ?>
        </ol>
        <div class="hr clearfix">&nbsp;</div>
<?php
if ( !comments_open() ) :
// If registration required and not logged in.
elseif ( get_option('comment_registration') && !is_user_logged_in() ) :
?>
<p>你必须 <a href="<?php echo wp_login_url( get_permalink() ); ?>">登录</a> 才能发表评论.</p>
<?php else  : ?>
<!-- Comment Form -->
<form id="commentform" name="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
    <h3>发表评论</h3>
    <div class="hr dotted clearfix">&nbsp;</div>
    <ul>
        <?php if ( !is_user_logged_in() ) : ?>
        <li class="clearfix">
            <label for="name">昵称</label>
            <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="23" tabindex="1" />
        </li>
        <li class="clearfix">
            <label for="email">电子邮件</label>
            <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="23" tabindex="2" />
        </li>
        <li class="clearfix">
            <label for="email">网址(选填)</label>
            <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="23" tabindex="3" />
        </li>
        <?php else : ?>
        <li class="clearfix">您已登录:<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出登录">退出 &raquo;</a></li>
        <?php endif; ?>
        <li class="clearfix">
            <label for="message">评论内容</label>
            <textarea id="message comment" name="comment" tabindex="4" rows="3" cols="40"></textarea>
        </li>
        <li class="clearfix">
            <!-- Add Comment Button -->
            <a href="javascript:void(0);" onClick="Javascript:document.forms['commentform'].submit()" class="button medium black right">发表评论</a> </li>
    </ul>
    <?php comment_id_fields(); ?>
    <?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; ?>
