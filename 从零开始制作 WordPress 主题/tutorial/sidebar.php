<!-- 侧边栏 sidebar-->
<div class="sidebar">
    <ul>
        <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
        <li id="search">
            <?php include(TEMPLATEPATH . '/searchform.php'); ?>
        </li>
        <?php wp_list_pages('depth=3&title_li=<h2>Pages</h2>'); ?>
        <li>
            <?php _e('Categories');?>
            <ul>
                <?php wp_list_cats('sort_colmn=name&optioncount=1&hierarchical=0');?>
            </ul>
        </li>
        <li>
            <?php _e('Archives');?>
            <ul>
                <?php wp_get_archives('type=monthly');?>
            </ul>
        </li>
        <li>
        <?php _e('calendar');?>
            <ul>
                <?php get_calendar();?>
            </ul>
        </li>
        <?php get_links_list(); ?>
        <li>
        <h2><?php _e('Meta'); ?></h2>
            <ul>
                <?php wp_register(); ?>
                    <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </li>
    <?php endif;?>
    </ul>
</div>
