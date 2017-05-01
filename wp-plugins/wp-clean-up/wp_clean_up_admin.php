<?php
function wp_clean_up_admin() {
	add_options_page('WP Clean Up Options', 'WP Clean Up','manage_options', __FILE__, 'wp_clean_up_page');
}
function wp_clean_up_page(){
?>
<div class="wrap">
	
<?php screen_icon(); ?>
<h2>WP Clean Up</h2>

<?php
function wp_clean_up($type){
	global $wpdb;
	switch($type){
		case "revision":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_type = 'revision'";
			$wpdb->query($wcu_sql);
			break;
		case "draft":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_status = 'draft'";
			$wpdb->query($wcu_sql);
			break;
		case "autodraft":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_status = 'auto-draft'";
			$wpdb->query($wcu_sql);
			break;
		case "moderated":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = '0'";
			$wpdb->query($wcu_sql);
			break;
		case "spam":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'";
			$wpdb->query($wcu_sql);
			break;
		case "trash":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'";
			$wpdb->query($wcu_sql);
			break;
		case "postmeta":
			$wcu_sql = "DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
			//$wcu_sql = "DELETE FROM $wpdb->postmeta WHERE NOT EXISTS ( SELECT * FROM $wpdb->posts WHERE $wpdb->postmeta.post_id = $wpdb->posts.ID )";
			$wpdb->query($wcu_sql);
			break;
		case "commentmeta":
			$wcu_sql = "DELETE FROM $wpdb->commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM $wpdb->comments)";
			$wpdb->query($wcu_sql);
			break;
		case "relationships":
			$wcu_sql = "DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id=1 AND object_id NOT IN (SELECT id FROM $wpdb->posts)";
			$wpdb->query($wcu_sql);
			break;
		case "feed":
			$wcu_sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '_site_transient_browser_%' OR option_name LIKE '_site_transient_timeout_browser_%' OR option_name LIKE '_transient_feed_%' OR option_name LIKE '_transient_timeout_feed_%'";
			$wpdb->query($wcu_sql);
			break;
	}
}

function wp_clean_up_count($type){
	global $wpdb;
	switch($type){
		case "revision":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'revision'";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "draft":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'draft'";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "autodraft":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'auto-draft'";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "moderated":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '0'";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "spam":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 'spam'";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "trash":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 'trash'";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "postmeta":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
			//$wcu_sql = "SELECT COUNT(*) FROM $wpdb->postmeta WHERE NOT EXISTS ( SELECT * FROM $wpdb->posts WHERE $wpdb->postmeta.post_id = $wpdb->posts.ID )";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "commentmeta":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM $wpdb->comments)";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "relationships":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id=1 AND object_id NOT IN (SELECT id FROM $wpdb->posts)";
			$count = $wpdb->get_var($wcu_sql);
			break;
		case "feed":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->options WHERE option_name LIKE '_site_transient_browser_%' OR option_name LIKE '_site_transient_timeout_browser_%' OR option_name LIKE '_transient_feed_%' OR option_name LIKE '_transient_timeout_feed_%'";
			$count = $wpdb->get_var($wcu_sql);
			break;
	}
	return $count;
}

function wp_clean_up_optimize(){
	global $wpdb;
	$wcu_sql = 'SHOW TABLE STATUS FROM `'.DB_NAME.'`';
	$result = $wpdb->get_results($wcu_sql);
	foreach($result as $row){
		$wcu_sql = 'OPTIMIZE TABLE '.$row->Name;
		$wpdb->query($wcu_sql);
	}
}

	$wcu_message = '';

	if(isset($_POST['wp_clean_up_revision'])){
		wp_clean_up('revision');
		$wcu_message = __("All revisions deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_draft'])){
		wp_clean_up('draft');
		$wcu_message = __("All drafts deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_autodraft'])){
		wp_clean_up('autodraft');
		$wcu_message = __("All autodrafts deleted!","WP-Clean-Up");
	}
	
	if(isset($_POST['wp_clean_up_moderated'])){
		wp_clean_up('moderated');
		$wcu_message = __("All moderated comments deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_spam'])){
		wp_clean_up('spam');
		$wcu_message = __("All spam comments deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_trash'])){
		wp_clean_up('trash');
		$wcu_message = __("All trash comments deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_postmeta'])){
		wp_clean_up('postmeta');
		$wcu_message = __("All orphan postmeta deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_commentmeta'])){
		wp_clean_up('commentmeta');
		$wcu_message = __("All orphan commentmeta deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_relationships'])){
		wp_clean_up('relationships');
		$wcu_message = __("All orphan relationships deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_feed'])){
		wp_clean_up('feed');
		$wcu_message = __("All dashboard transient feed deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_all'])){
		wp_clean_up('revision');
		wp_clean_up('draft');
		wp_clean_up('autodraft');
		wp_clean_up('moderated');
		wp_clean_up('spam');
		wp_clean_up('trash');
		wp_clean_up('postmeta');
		wp_clean_up('commentmeta');
		wp_clean_up('relationships');
		wp_clean_up('feed');
		$wcu_message = __("All redundant data deleted!","WP-Clean-Up");
	}

	if(isset($_POST['wp_clean_up_optimize'])){
		wp_clean_up_optimize();
		$wcu_message = __("Database Optimized!","WP-Clean-Up");
	}

	if($wcu_message != ''){
		echo '<div id="message" class="updated fade"><p><strong>' . $wcu_message . '</strong></p></div>';
	}
?>

<p>
<table class="widefat" style="width:419px;">
	<thead>
		<tr>
			<th scope="col"><?php _e('Type','WP-Clean-Up'); ?></th>
			<th scope="col"><?php _e('Count','WP-Clean-Up'); ?></th>
			<th scope="col"><?php _e('Operate','WP-Clean-Up'); ?></th>
		</tr>
	</thead>
	<tbody id="the-list">
		<tr class="alternate">
			<td class="column-name">
				<?php _e('Revision','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('revision'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_revision" value="revision" />
					<input type="submit" class="<?php if(wp_clean_up_count('revision')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('Draft','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('draft'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_draft" value="draft" />
					<input type="submit" class="<?php if(wp_clean_up_count('draft')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr class="alternate">
			<td class="column-name">
				<?php _e('Auto Draft','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('autodraft'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_autodraft" value="autodraft" />
					<input type="submit" class="<?php if(wp_clean_up_count('autodraft')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('Moderated Comments','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('moderated'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_moderated" value="moderated" />
					<input type="submit" class="<?php if(wp_clean_up_count('moderated')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr class="alternate">
			<td class="column-name">
				<?php _e('Spam Comments','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('spam'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_spam" value="spam" />
					<input type="submit" class="<?php if(wp_clean_up_count('spam')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('Trash Comments','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('trash'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_trash" value="trash" />
					<input type="submit" class="<?php if(wp_clean_up_count('trash')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr class="alternate">
			<td class="column-name">
				<?php _e('Orphan Postmeta','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('postmeta'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_postmeta" value="postmeta" />
					<input type="submit" class="<?php if(wp_clean_up_count('postmeta')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('Orphan Commentmeta','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('commentmeta'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_commentmeta" value="commentmeta" />
					<input type="submit" class="<?php if(wp_clean_up_count('commentmeta')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr class="alternate">
			<td class="column-name">
				<?php _e('Orphan Relationships','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('relationships'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_relationships" value="relationships" />
					<input type="submit" class="<?php if(wp_clean_up_count('relationships')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('Dashboard Transient Feed','WP-Clean-Up'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('feed'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_feed" value="feed" />
					<input type="submit" class="<?php if(wp_clean_up_count('feed')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('Delete','WP-Clean-Up'); ?>" />
				</form>
			</td>
		</tr>
	</tbody>
</table>
</p>
<p>
<form action="" method="post">
	<input type="hidden" name="wp_clean_up_all" value="all" />
	<input type="submit" class="button-primary" value="<?php _e('Delete All','WP-Clean-Up'); ?>" />
</form>
</p>
<br />

<table class="widefat" style="width:419px;">
	<thead>
		<tr>
			<th scope="col"><?php _e('Table','WP-Clean-Up'); ?></th>
			<th scope="col"><?php _e('Size','WP-Clean-Up'); ?></th>
		</tr>
	</thead>
	<tbody id="the-list">
	<?php
		global $wpdb;
		$total_size = 0;
		$alternate = " class='alternate'";
		$wcu_sql = 'SHOW TABLE STATUS FROM `'.DB_NAME.'`';
		$result = $wpdb->get_results($wcu_sql);

		foreach($result as $row){

			$table_size = $row->Data_length + $row->Index_length;
			$table_size = $table_size / 1024;
			$table_size = sprintf("%0.3f",$table_size);

			$every_size = $row->Data_length + $row->Index_length;
			$every_size = $every_size / 1024;
			$total_size += $every_size;

			echo "<tr". $alternate .">
					<td class='column-name'>". $row->Name ."</td>
					<td class='column-name'>". $table_size ." KB"."</td>
				</tr>\n";
			$alternate = (empty($alternate)) ? " class='alternate'" : "";
		}
	?>
	</tbody>
	<tfoot>
		<tr>
			<th scope="col"><?php _e('Total','WP-Clean-Up'); ?></th>
			<th scope="col" style="font-family:Tahoma;"><?php echo sprintf("%0.3f",$total_size).' KB'; ?></th>
		</tr>
	</tfoot>
</table>
<p>
<form action="" method="post">
	<input type="hidden" name="wp_clean_up_optimize" value="optimize" />
	<input type="submit" class="button-primary" value="<?php _e('Optimize','WP-Clean-Up'); ?>" />
</form>
</p>
<br />

<h3>Related Links</h3>
1. <a href="http://boliquan.com/wp-clean-up/" target="_blank">WP Clean Up (FAQ)</a> | <a href="http://wordpress.org/plugins/wp-clean-up/" target="_blank">Download</a><br />
2. <a href="http://boliquan.com/wp-smtp/" target="_blank">WP SMTP</a> | <a href="http://wordpress.org/plugins/wp-smtp/" target="_blank">Download</a><br />
3. <a href="http://boliquan.com/wp-code-highlight/" target="_blank">WP Code Highlight</a> | <a href="http://wordpress.org/plugins/wp-code-highlight/" target="_blank">Download</a><br />
4. <a href="http://boliquan.com/wp-slug-translate/" target="_blank">WP Slug Translate</a> | <a href="http://wordpress.org/plugins/wp-slug-translate/" target="_blank">Download</a><br />
5. <a href="http://boliquan.com/wp-anti-spam/" target="_blank">WP Anti Spam</a> | <a href="http://wordpress.org/plugins/wp-anti-spam/" target="_blank">Download</a><br />
6. <a href="http://boliquan.com/yg-share/" target="_blank">YG Share</a> | <a href="http://wordpress.org/plugins/yg-share/" target="_blank">Download</a>

<br /><br />
<?php $donate_url = plugins_url('/img/paypal_32_32.jpg', __FILE__);?>
<?php $paypal_donate_url = plugins_url('/img/paypal_donate_email.jpg', __FILE__);?>
<?php $ali_donate_url = plugins_url('/img/alipay_donate_email.jpg', __FILE__);?>
<div class="icon32"><img src="<?php echo $donate_url; ?>" alt="Donate" /></div>
<h2>Donate</h2>
<p>
If you find my work useful and you want to encourage the development of more free resources, you can do it by donating.
</p>
<p>
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SCWY6NPFRR8EY" target="_blank"><img src="<?php echo $paypal_donate_url; ?>" alt="Paypal Donate" title="Paypal" /></a>
&nbsp;
<a href="https://www.alipay.com/" target="_blank"><img src="<?php echo $ali_donate_url; ?>" alt="Alipay Donate" title="Alipay" /></a>
</p>
<br />

<div style="text-align:center; margin:60px 0 10px 0;">&copy; <?php echo date("Y"); ?> BoLiQuan.COM</div>

</div>
<?php 
}
add_action('admin_menu', 'wp_clean_up_admin');
?>