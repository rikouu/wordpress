<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]> <html class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->
<head>
	<meta charset="UTF-8">	
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<title><?php  wp_title('|', true, 'right'); if (is_home ()) echo get_option('blogname'); else bloginfo("name");?></title>
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
</head>
<body>
<div id="header">
	<div id="wrap">
		<span class="header-title"><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></span>
		<div id="search">
			<form  class="form-search" id="searchform" method="get" action="<?php bloginfo('home'); ?>">
			  <div class="input">
				<input type="text" value="<?php the_search_query(); ?>" placeholder="输入关键字搜索"<?php if( is_search() ){ echo ' value="'.$s.'"'; } ?> autofocus="" x-webkit-speech="" class="spantags search-query" name="s" id="s" size="20" />
				<input type="submit" class="btn" value="搜索" />
				</div>
			</form>
		</div>
	</div>
</div>




<div id="nav">
              <div id="wrap">
		                     <ul>
                                   <li><a href="../index.php">首页</a></li>			
		                     </ul>
              </div>
</div>
