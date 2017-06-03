# WordPress主题导航菜单制作的几种方法(一) #

&emsp;&emsp;在WordPress主题制作中，导航菜单的制作算是一个重点，已经写好导航菜单的HTML代码，放在WordPress主题中如何动态调用呢？本文将给你介绍几种编写PHP代码动态实现导航的方法，本文也将只侧重于动态代码的开发，不会教你如何编写HTML、CSS和Javascript来实现华丽的导航菜单。


## WP 3.0自定义菜单的制作 ##

&emsp;&emsp;WordPress 3.0之后的版本开始支持自定义动态菜单，所谓的动态菜单，也就是允许用户自行决定将哪些项目添加到导航菜单中，进入WordPress的管理后台 - 外观 - 菜单栏目，通过拖拉相应的栏目，即可创建自己的菜单。这对于WordPress主题开发者和使用者来说，都是皆大欢喜的事情。要想实现自定义菜单，需要用到的函数是wp\_nav\_menu()，给这个函数传递一些参数就可以输出自定义菜单菜单，下面简单讲讲如何使用使用这个函数。


&emsp;&emsp;首先，在主题目录下的functions.php的 <?php ..... ?> 之间，添加以下菜单注册代码，这样你就可以在主题文件中使用wp\_nav\_menu函数了：


    
    // This theme uses wp_nav_menu() in one location.
    register_nav_menus();



接着我们在主题的导航栏处调用wp\_nav\_menu()，即可输出导航菜单HTML代码：


    <?php 
    // 列出顶部导航菜单，菜单名称为mymenu，只列出一级菜单
    wp_nav_menu( array( 'menu' => 'mymenu', 'depth' => 1) );
    ?>


以上代码输出的HTML代码形式如下：



    <div class="menu-menu-container">
    <ul class="menu" id="menu-menu">
    <li class="..." id="menu-item-1"><a href="...">首页</a></li>
    <li class="..." id="menu-item-2"><a href="...">分类A</a></li>
    ...
    </ul>
    </div>


&emsp;&emsp;这里列出的 li 项为你在后台 - 外观 - 菜单添加的栏目，如果你还没有在后台添加菜单，导航栏将列出所有页面。另外，wp\_nav\_menu会为每个 li 添加class，不同的class标记这个菜单项的属性，如当前打开的是某个文章页面，分类A 就是这篇文章所属的分类，那么 分类A 所在的 li 将会如下代码所示：



    <li class="menu-item menu-item-type-taxonomy current-post-ancestor current-menu-parent current-post-parent menu-item-5" id="menu-item-2"><a href="...">分类A</a></li>



&emsp;&emsp;如果是在首页，那么首页的菜单项的 li 可能会如下所示：



` <li class="menu-item menu-item-type-custom current-menu-item current_page_item menu-item-home menu-item-4" id="menu-item-1"><a href="..">首页</a></li>` 



&emsp;&emsp;从这些class的名称就知道它们的作用，通过给这些class添加css属性，可以达到如高亮当前导航菜单的目的，如将当前菜单链接定义成红色：


    .current-post-ancestor a, .current-menu-parent a, .current-menu-item a, .current_page_item a {
    color: red;
    }



&emsp;&emsp;好了，WordPress 3.0的自定义菜单的调用就是这么简单。wp\_nav\_menu还有很多参数，如自定义 ul 节点、ul 父节点的id和class的参数等等，详情可以参考文档：[官方文档](http://codex.wordpress.org/Function_Reference/wp_nav_menu "官方文档") | [中文文档](http://www.neoease.com/how-to-create-wordpress-navi-menu/ "中文文档")




## 使用分类和页面作为导航栏 ##

&emsp;&emsp;在 WordPress 3.0 之前，大部分WordPress主题都是拿页面作为导航栏的，导航中只能添加页面，显得不够自由。我刚用WordPress 2.7的时候，就为此问题烦恼，最后翻了文档，查了一些资料，实现了在导航中添加分类，详情请看我之前写的文章：[WordPress 分类做导航栏，并高亮显示](http://www.ludou.org/wordpress-highlight.html "WordPress 分类做导航栏，并高亮显")

## 非常规导航栏的制作 ##

&emsp;&emsp;以上提到的两种方式，都是使用WordPress自带的函数来实现，他们输入的HTML代码也都是限定好的，就是使用 ul li 的形式来构建菜单列表：如：


    <ul>
    <li class="..">...</li>
    <li class="..">...</li>
    </ul>



&emsp;&emsp;如果主题的前端代码不是你写的，而且导航栏的代码写得很龟毛，这根本不是上面的WordPress标准的 ul 导航栏形式，如下面的代码：


    <dl>
    <dt><strong>标题</strong></dt>
    <dd><a target="_blank" title="#" href="#">菜单A</a></dd>
    <dd><a target="_blank" title="#" href="#">菜单B</a></dd>
    </dl>


&emsp;&emsp;重写前端代码？我想谁都不愿意这样做，那怎么办呢？还有，如果导航栏不使用分类和页面，也不让使用自定义菜单，那怎么办？在实际的应用中，我们还会遇到各种各样且稀奇古怪的需求，下期内容我们将继续探讨这个问题！详见：**WordPress主题导航菜单制作的几种方法(二)**










































