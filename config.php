<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/7
 * Time: 22:23
 */
//初步定义此为高中成绩单
$gconfig = array(
    //教育阶段
    'Edustage'=>"高中",
    //科目=>总分
    'subject'=>array('语文'=>150,'数学'=>150,'英语'=>150,'物理'=>100,'化学'=>100,'生物'=>100,'政治'=>100,'历史'=>100,'地理'=>100),

    //缓存文件
    'cache'=>"data/cache.php",

    //表格头
    'excelhead'=>array('姓名','语文','数学','英语','物理','化学','生物','政治','历史','地理','总分','班级'),

    'color'=>array(
        'Black','Blue','Brown','Coral','Cyan','Gold','Green','Maroon','Navy','Orange','Yellow'
    )
);

define("One_Width",15);
define("IMG_PATH",'image/');