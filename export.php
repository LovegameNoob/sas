<?php
/**
 * 导出分析数据
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/10
 * Time: 14:29
 */
require "lib/PHPExcel.php";
require "config.php";
require "function.php";
$cache = unserialize(file_get_contents($gconfig["cache"]));
//print_r($cache['analyzes']);
//die;
$objPHPExcel=new PHPExcel();
$objSheet=$objPHPExcel->getActiveSheet();
$row = 1;
$height = 250;
$leglength = count($cache['analyzes']);
if($leglength>5){
    $addedH = ceil($leglength/5)*30;
    $height = 250 + $addedH;
}
$excelhead = $gconfig['excelhead'];

//设置A-N;
$subjectkey = range('A',chr(ord('A')+count($excelhead)-1));
$subcombine = array_combine($subjectkey,$excelhead);
$objSheet->getDefaultRowDimension()->setRowHeight(15);

foreach($subcombine as $sk=>$sv)
{
    $objSheet->setCellValue($sk."1",$sv);
}

$row = 2;

foreach($cache['allstudent'] as $stuk=>$stuv)
{
    foreach(array_values($stuv) as $sk=>$sv)
    {
        $objSheet->setCellValue($subjectkey[$sk].$row,$sv);
    }

    $row++;
}

if ($handle = opendir(IMG_PATH)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".."&&$file != "index.html") {
            //unlink(IMG_PATH.$file);
            $img=new PHPExcel_Worksheet_Drawing();
            $img->setPath(IMG_PATH.$file);//写入图片路径
            //$img->setHeight(100);//写入图片高度
            //$img->setWidth(100);//写入图片宽度
            $img->setOffsetX(1);//写入图片在指定格中的X坐标值
            $img->setOffsetY(1);//写入图片在指定格中的Y坐标值
            $img->setRotation(1);//设置旋转角度
            $img->getShadow()->setVisible(true);//
            $img->getShadow()->setDirection(50);//
            $img->setCoordinates("B".($row+2));//设置图片所在表格位置
            $img->setWorksheet($objSheet);//把图片写到当前的表格中

            $row = $row+ceil($height/15);
        }
    }
    closedir($handle);
}


$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');//生成excel文件
browser_export("analuzes.xls");
$objWriter->save("php://output");
