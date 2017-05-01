# WordPress主题导航菜单制作的几种方法(二)#


&emsp;&emsp;WordPress主题导航菜单制作的几种方法(一)，上一篇教程讲了如何使用WordPress内置的函数来创建导航菜单，但是这些函数生成的HTML代码都是固定的，你很难去定义导航菜单的HTML代码。本文将为你介绍几种更为自由的方法来创建导航菜单，而这些方法不仅仅可以用于导航菜单。当然本文只是给你提供一个解决问题的思路，并不是像菜谱那样的教程，一看、一复制就能用在你的项目。

## 一、使用get_terms()来获取分类列表 ##

&emsp;&emsp;使用get_terms()可以获取你的文章分类、链接分类和自定义分类等，给get_terms()传递相应的参数可以给你返回一个对象数组，这个数组就是你想要的所有分类，以下是get_terms()的函数原型：



    <?php get_terms( $taxonomies, $args ) ?>




## $taxonomies： ##


&emsp;&emsp;该参数是你想要获取的分类类别，可选值包括："category"，"link_category"，"my_taxonomy"，他们分别代表文章分类、链接分类以及你自定义的分类，其中my_taxonomy是你自定义的分类名称。


##$args： ##


&emsp;&emsp;该参数是分类的筛选参数，用于控制获取你要获取的分类，包括你想要获取多少个分类、如何排序、父分类以及是否输出空的分类等，具体请参考WordPress官方文档：Function Reference/get terms，或者参考中文的简要翻译：常用函数-get_terms()

&emsp;&emsp;下面是一个该函数的使用示例，这里将显示一个所有文章分类的<ul\><li\>..</li\>\.\.</ul\>形式的无序列表，当然我们可以把它看成菜单：



    <ul id="menu">  
    <?php
    // 获取分类
    $terms = get_terms('category', 'orderby=name&hide_empty=0' );
    
    // 获取到的分类数量
    $count = count($terms);
    if($count > 0){
    // 循环输出所有分类信息
    foreach ($terms as $term) {
    echo '<li><a href="'.get_term_link($term, $term->slug).'" title="'.$term->name.'">'.$term->name.'</a></li>';
    }
    }
    ?>  
    </ul>




&emsp;&emsp;get\_terms()函数返回一个对象数组$terms，我们首先判断这个数组是否为空，为空说明并没有获取到任何分类，如果不为空那么你就可以输出分类了。$terms的每个数组项就是一个对象，部分对象属性的意义如：slug：分类缩略名，name：分类名，term_id：分类id。如以上代码所示，你可以通过$term->name来获取对象的属性值。



## 二、使用读数据库的方式获取分类列表 ##

&emsp;&emsp;如果你了解WordPress的数据库，可以发现WordPress的分类信息都存储在wp\_terms和wp\_term\_taxonomy这两个表中，wp\_terms存储基本信息（包括文章分类、文章标签和链接分类等），wp\_term\_taxonomy用于存储进一步描述（用于存储描述、区分分类和标签等）。我们可以使用SQL来从这两个表中获取我们想要的分类列表：



    <ul id="menu">  
    <?php 
    $cats = $wpdb->get_results("SELECT {$wpdb->prefix}terms.term_id, name
    FROM {$wpdb->prefix}term_taxonomy, {$wpdb->prefix}terms
    WHERE {$wpdb->prefix}term_taxonomy.term_id = {$wpdb->prefix}terms.term_id
    AND taxonomy = 'category'");
    
    if($cats) {
    foreach($cats as $cat) {
    echo '<li><a href="'.get_category_link($cat->term_id).'" title="'.$cat->name.'">'.$cat->name.'</a></li>';
    }
    }
    ?>  
    </ul>



## 三、如何获取当前分类的id ##

&emsp;&emsp;有些时候我们需要制作一个子导航，如http://www.nashowgroup.com/?p=58&lang=zh左边的人力资源导航，这个导航可以是任意项目，如当前分类下的子分类或者当前分类下的文章等。那么首要问题就是，如何获取当前分类的id，这样才可以进行下一步的动作。

在分类页获取当前分类的id：



    if ( is_category() ) {
    $cat_id = get_query_var('cat');
    }




在文章页获取该文章的第一个分类：


    $cats = get_the_category();
    if($cats)
    $cat_id = $cats[0]->cat_ID;




## 四、子导航的制作 ##

&emsp;&emsp;上面我们讲解了如何获取当前分类的id，下面我们来讲讲如何制作子导航。首先，我们来制作一个当前分类下子分类的子导航，这里用到wp\_list\_categories()来列出子分类，当然你可以用我前面介绍的两种方法来获取分类。：


    <ul>
    <?php
    // 这里我们用到上面获取到的$cat_id，获取该分类下的所有子分类
    wp_list_categories('orderby=name&hide_empty=0&child_of=' . $cat_id);
    ?> 
    </ul>



&emsp;&emsp;如果你的网站规模比较小，一个分类下的文章也不多，那么你可以在子导航中列出这个分类下的所有文章：


    <ul>
    <?php
    global $wp_query;
    
    $query = array ( 'cat' => $cat_id, 'orderby' => title, 'order'=> ASC ); 
    $queryObject = new WP_Query($query); 
    
    if ($queryObject->have_posts()) :
    while ($queryObject->have_posts()) :
    $queryObject->the_post();
    ?>
    <li><a <?php if($post->ID == $wp_query->post->ID) echo 'class="chose"'; ?> href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
    <?php endwhile; wp_reset_postdata(); endif; ?>
    </ul>


&emsp;&emsp;以上代码中用到了WP_Query来获取文章列表，该对象的使用方法，可以参考WordPress的官方文档：Class Reference/WP Query和Function Reference/query posts。class="chose"用于高亮当前文章的菜单项，css规则你可以自己定义。



## 五、页面page的获取 ##

&emsp;&emsp;WordPress的页面page可以通过wp\_list\_pages()来列出，不过这个函数输出的HTML都是固定的，如果你想要自定义这些HTML，可以使用get\_pages()来获取页面列表，代码示例如下：


    <ul id="menu">
    $mypages = get_pages();
    
    if(count($mypages) > 0) {
    foreach($mypages as $page) {
    echo '<li><a href="'.get_page_link($page->ID).'" title="'.$page->post_title.'">'.$page->post_title.'</a></li>';
    }
    }
    else {
    echo '<li><a href="#">没有页面</a></li>';
    }
    </ul>

 
制作就完成了.






























































































