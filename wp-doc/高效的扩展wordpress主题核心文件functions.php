相信大家对wordpress主题中 的functions.php文件一定不陌生，本站很多教程中的代码也是直接加
到functions.php就可以使用的，但是随着代码多了以后想修改 functions.php就变得不方便了，而
且一旦代码错误再恢复逐渐庞大的functions.php文件也就麻烦起来了，对于新手来说很可能就找不 
出问题所在了。今天小V就教大家一个更高效，更方便的方法来为functions.php扩展功能。
第一步：在主题文件夹下新建一个名为inc的文件夹
第二步：将以下代码加入到当前主题的functions.php文件中，代码如下：
define('INC', TEMPLATEPATH.'/inc');
IncludeAll( INC );
function IncludeAll($dir){
    $dir = realpath($dir);
    if($dir){
        $files = scandir($dir);
        sort($files);
        foreach($files as $file){
            if($file == '.' || $file == '..'){
                continue;
            }elseif(preg_match('/.php$/i', $file)){
                include_once $dir.'/'.$file;
            }
        }
    }
}
以后每次为主题扩展功能的时候只要将代码保存为一个新的php文件，文件名不限，但最好是英文或
数字，然后将文件放入到inc目录下即可，效果和直 接将代码加到functions.php文件一样，而且一
旦代码出错只要直接删除出错代码的文件即可。此方法不仅降低了新人修改 functions.php造成网站
无法访问的风险，而且不用一个一个的去include php script，使得代码更加高效。