<?php
/**
 * 生成测试数据
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/6
 * Time: 16:13
 */

$dir=dirname(__FILE__);//查找当前脚本所在路径
require "./lib/PHPExcel.php";//引入PHPExcel
require "config.php";
require "function.php";
$objPHPExcel=new PHPExcel();//实例化PHPExcel类， 等同于在桌面上新建一个excel

$bjx = "赵|钱|孙|李|周|吴|郑|王|冯|陈|楮|卫|蒋|沈|韩|杨|朱|秦|尤|许|何|吕|施|张|孔|曹|严|华|金|魏|陶|姜|戚|谢|邹|喻|柏|水|窦|章|云|苏|潘|葛|奚|范|彭|郎|鲁|韦|昌|马|苗|凤|花|方|俞|任|袁|柳|酆|鲍|史|唐|费|廉|岑|薛|雷|贺|倪|汤|滕|殷|罗|毕|郝|邬|安|常|乐|于|时|傅|皮|卞|齐|康|伍|余|元|卜|顾|孟|平|黄|和|穆|萧|尹|姚|邵|湛|汪|祁|毛|禹|狄|米|贝|明|臧|计|伏|成|戴|谈|宋|茅|庞|熊|纪|舒|屈|项|祝|董|梁|杜|阮|蓝|闽|席|季|麻|强|贾|路|娄|危|江|童|颜|郭|梅|盛|林|刁|锺|徐|丘|骆|高|夏|蔡|田|樊|胡|凌|霍|虞|万|支|柯|昝|管|卢|莫|经|房|裘|缪|干|解|应|宗|丁|宣|贲|邓|郁|单|杭|洪|包|诸|左|石|崔|吉|钮|龚|程|嵇|邢|滑|裴|陆|荣|翁|荀|羊|於|惠|甄|麹|家|封|芮|羿|储|靳|汲|邴|糜|松|井|段|富|巫|乌|焦|巴|弓|牧|隗|山|谷|车|侯|宓|蓬|全|郗|班|仰|秋|仲|伊|宫|宁|仇|栾|暴|甘|斜|厉|戎|祖|武|符|刘|景|詹|束|龙|叶|幸|司|韶|郜|黎|蓟|薄|印|宿|白|怀|蒲|邰|从|鄂|索|咸|籍|赖|卓|蔺|屠|蒙|池|乔|阴|郁|胥|能|苍|双|闻|莘|党|翟|谭|贡|劳|逄|姬|申|扶|堵|冉|宰|郦|雍|郤|璩|桑|桂|濮|牛|寿|通|边|扈|燕|冀|郏|浦|尚|农|温|别|庄|晏|柴|瞿|阎|充|慕|连|茹|习|宦|艾|鱼|容|向|古|易|慎|戈|廖|庾|终|暨|居|衡|步|都|耿|满|弘|匡|国|文|寇|广|禄|阙|东|欧|殳|沃|利|蔚|越|夔|隆|师|巩|厍|聂|晁|勾|敖|融|冷|訾|辛|阚|那|简|饶|空|曾|毋|沙|乜|养|鞠|须|丰|巢|关|蒯|相|查|后|荆|红|游|竺|权|逑|盖|益|桓|公|万俟|司马|上官|欧阳|夏侯|诸葛|闻人|东方|赫连|皇甫|尉迟|公羊|澹台|公冶|宗政|濮阳|淳于|单于|太叔|申屠|公孙|仲孙|轩辕|令狐|锺离|宇文|长孙|慕容|鲜于|闾丘|司徒|司空|丌官|司寇|仉|督|子车|颛孙|端木|巫马|公西|漆雕|乐正|壤驷|公良|拓拔|夹谷|宰父|谷梁|晋|楚|阎|法|汝|鄢|涂|钦|段干|百里|东郭|南门|呼延|归|海|羊舌|微生|岳|帅|缑|亢|况|后|有|琴|梁丘|左丘|东门|西门|商|牟|佘|佴|伯|赏|南宫|墨|哈|谯|笪|年|爱|阳|佟|第五|言|福";
$bjxarr = explode("|",$bjx);
//echo $bjxarr[array_rand($bjxarr)];
$man = "明、国、文、华、德、建、志、永、林、成、军、平、福、荣、生、海、金、忠、伟、玉、兴、祥、强、清、春、庆、宝、新、东、光";
$woman = "英、秀、玉、华、珍、兰、芳、丽、淑、桂、凤、素、梅、美、玲、红、春、云、琴、惠";
$subject = array('语文','数学','英语','物理','化学','生物','政治','历史','地理');
$unit = range('B','J');
$manarr = explode("、",$man);
$womanarr = explode("、",$woman);

for($sheet=1;$sheet<=4;$sheet++) {
    if($sheet > 1){
        $objPHPExcel->createSheet();//创建新的内置表
    }
    $objPHPExcel->setActiveSheetIndex($sheet-1);
    $objSheet=$objPHPExcel->getActiveSheet();//获取当前活动sheet
    $objSheet->setTitle("高一".$sheet."班");//给当前活动sheet起个名称
    $objSheet->setCellValue("A1","姓名");
    foreach ($subject as $sk=>$th) {
        $objSheet->setCellValue($unit[$sk]."1",$th);
    }
    $j=2;
    for ($i = 0; $i < mt_rand(50,60); $i++) {
        if ($i % 2)
            $objSheet->setCellValue("A".$j,$bjxarr[array_rand($bjxarr)] . $manarr[array_rand($manarr)] . $manarr[array_rand($manarr)]);
        else
            $objSheet->setCellValue("A".$j,$bjxarr[array_rand($bjxarr)] . $womanarr[array_rand($womanarr)] . $womanarr[array_rand($womanarr)]);

        foreach ($subject as $k => $v) {
            if ($k<3)
                $objSheet->setCellValue($unit[$k].$j,mt_rand(20, 150));
            else
                $objSheet->setCellValue($unit[$k].$j,mt_rand(10, 100));
        }
        $j++;
    }
//    echo "<table>";
//    echo "<th>姓名</th>";
//    foreach ($subject as $th) {
//        echo "<th>$th</th>";
//    }
//    for ($i = 0; $i < mt_rand(50,60); $i++) {
//        echo "<tr>";
//        if ($i % 2)
//            echo "<td>" . $bjxarr[array_rand($bjxarr)] . $manarr[array_rand($manarr)] . $manarr[array_rand($manarr)] . "</td>";
//        else
//            echo "<td>" . $bjxarr[array_rand($bjxarr)] . $womanarr[array_rand($womanarr)] . $womanarr[array_rand($womanarr)] . "</td>";
//        foreach ($subject as $k => $v) {
//            if ($k < 3)
//                echo "<td>" . mt_rand(20, 150) . "</td>";
//            else
//                echo "<td>" . mt_rand(10, 100) . "</td>";
//        }
//        echo "</tr>";
//    }
//    echo "</table>";
}
//$mysqli = new mysqli('localhost','root','root','test');
//
//$mysqli->query();
//
//$mysqli->close();
$objPHPExcel->setActiveSheetIndex(0);
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');//生成excel文件
//$objWriter->save($dir."/upload/report_analyze.xls");//保存文件
browser_export('student_result.xls');//输出到浏览器
$objWriter->save("php://output");
