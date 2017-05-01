    <!-- Column 2 / Sidebar -->
    <div class="grid_4">

    <?php if ( !function_exists('dynamic_sidebar')
                        || !dynamic_sidebar('First_sidebar') ) : ?>
        <h4>分类目录</h4>
        <ul>
            <?php wp_list_categories('depth=1&title_li=&orderby=id&show_count=0&hide_empty=1&child_of=0'); ?>
        </ul>
    <?php endif; ?>

    <?php if ( !function_exists('dynamic_sidebar')
                            || !dynamic_sidebar('Second_sidebar') ) : ?>
        <h4>最新文章</h4>
        <ul>
            <?php
                $posts = get_posts('numberposts=6&orderby=post_date');
                foreach($posts as $post) {
                    setup_postdata($post);
                    echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                }
                $post = $posts[0];
            ?>
        </ul>
    <?php endif; ?>

    <?php if ( !function_exists('dynamic_sidebar')
                            || !dynamic_sidebar('Third_sidebar') ) : ?>
        <h4>标签云</h4>
        <p><?php wp_tag_cloud('smallest=8&largest=22'); ?></p>
    <?php endif; ?>

    <?php if ( !function_exists('dynamic_sidebar')
                        || !dynamic_sidebar('Fourth_sidebar') ) : ?>
        <h4>文章存档</h4>
        <ul>
            <?php wp_get_archives('limit=10'); ?>
        </ul>
    <?php endif; ?>

    </div>
    <div class="hr grid_12 clearfix">&nbsp;</div>

