<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/7
 * Time: 14:31
 */

require "lib/PHPExcel.php";
require "config.php";
require "function.php";

$filepath = upload();
//$filepath = "upload/student_result.xls";
echo "正在分析....";
$inputFileType = PHPExcel_IOFactory::identify($filepath);
$reader = PHPExcel_IOFactory::createReader($inputFileType);
//开始数据读取
$PHPExcel = $reader->load($filepath);
$sheetNames = $PHPExcel->getSheetNames();
$subject = array_keys($gconfig['subject']);     //科目
$subvalue = array_values($gconfig['subject']); //总分

$cachedata = array();  //缓存所有数据

$allstudent = array(); //所有学生

$section = array();  //分段

$k = 0; //学生计数
foreach($sheetNames as $sheetIndex => $loadedSheetName) {
    $PHPExcel->setActiveSheetIndexByName($loadedSheetName);       // 通过 '工作表名称' 来设置当前工作表为激活状态
    // 接着对当前激活的工作表，进行读取、数据库写入
    $sheetData[$loadedSheetName] = $PHPExcel->getActiveSheet()->toArray(null,false,false,false);
    $thisheet = $sheetData[$loadedSheetName];
    array_shift($thisheet);

    //初始化分析结果
    foreach($subject as $subk=>$subv)
    {
        if($subvalue[$subk]%30==0){
            $sec = $subvalue[$subk]/30;
            $secv = 30;
        }else if($subvalue[$subk]%20==0){
            $sec = $subvalue[$subk]/20;
            $secv = 20;
        }else{
            $sec = $subvalue[$subk]/10;
            $secv = 10;
        }
        $analyze[$subv] = array(
            '及格率'=> 0,
            '优秀率'=> 0,
            '各分段人数'=> array_fill(1,$sec,0),
            '总分平均分'=> 0,
            '区间'=>$secv
        );
    }

    foreach($thisheet as $tk=>$tv)
    {
        $thisheet[$tk]['total'] = array_sum($thisheet[$tk]);
        //组装一个all
        $allstudent[$k] = $thisheet[$tk];
        $allstudent[$k]['class'] = $loadedSheetName;
        $k++;
        //及格人数
        $student = array_slice($tv, 1);
        foreach($student as $sk=>$sv)
        {
            //定义及格分数线
            $jigefen = $subvalue[$sk]*0.6;
            //定义优秀分数线
            $youxiufen = $subvalue[$sk]*0.9;
            //是否及格?
            if($sv-$jigefen>0)
                $analyze[$subject[$sk]]["及格率"]++;
            if($sv-$youxiufen>0)
                $analyze[$subject[$sk]]["优秀率"]++;
            //判断他是那个分段的
                $analyze[$subject[$sk]]["各分段人数"][ceil($sv/$analyze[$subject[$sk]]["区间"])]++;
            //总分平均分（先累加 最后求值）
                $analyze[$subject[$sk]]["总分平均分"]+=$sv;
            //echo "{$subject[$sk]}是第".floor(($sv/20)+1)."分段的"."<br>";
        }

    }
    //算出各科总分平均分
    foreach($analyze as $ak=>$av)
    {
        $analyze[$ak]['及格率'] = round($analyze[$ak]['及格率']/count($thisheet)*100);
        $analyze[$ak]['优秀率'] = round($analyze[$ak]['优秀率']/count($thisheet)*100);
        $analyze[$ak]['总分平均分'] = round($analyze[$ak]['总分平均分']/count($thisheet));
    }

    usort($thisheet,"mysort");
    $single[$loadedSheetName] = $thisheet;
    $analyzes[$loadedSheetName] = $analyze;
}

//全部学生名次排序
usort($allstudent,"mysort");

$cachedata['single'] = $single;
$cachedata['analyzes'] = $analyzes;
$cachedata['allstudent'] = $allstudent;
//创建文件,写入缓存
if(file_put_contents($gconfig["cache"],serialize($cachedata),LOCK_EX))
{
    header('Location: /student/display.php');
}

//及格率优秀率各分段人数总分平均分 各班班级间对比

//print_r($single);

function mysort($a,$b){
    if ($a['total'] == $b['total']) {
        return 0;
    }
    return ($a['total'] > $b['total']) ? -1 : 1;
}
