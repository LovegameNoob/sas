<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/7
 * Time: 21:32
 */

//require_once ('config.php');
require_once ('lib/jpgraph/jpgraph.php');
require_once ('lib/jpgraph/jpgraph_bar.php');
//$cache = unserialize(file_get_contents($gconfig["cache"]));
//print_r($cache['analyzes']);
//及格率柱状图

//alphabarex($cache['analyzes'],"语文",$gconfig["color"]);
//bartutexall($cache['analyzes'],$gconfig['subject'],$gconfig["color"],"及格率");

function createchart($analyzes,$subject,$color){

    $rootpath= 'image/';

    if ($handle = opendir($rootpath)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".."&&$file != "index.html") {
                unlink($rootpath.$file);
            }
        }
        closedir($handle);
    }

    //及格率
    bartutexall($analyzes,$subject,$color,"及格率");
    //优秀率
    bartutexall($analyzes,$subject,$color,"优秀率");
    //各分段人数
    foreach(array_keys($subject) as $k=>$v){
        $filename = $rootpath.'section'.$k.".jpg";
        alphabarex($analyzes,$v,$color,$filename);
    }
    //总分平均分
    bartutexall($analyzes,$subject,$color,"总分平均分");



}


//if($_GET['action']=='ratio')
//    bartutex($cache['analyzes'],$_GET['subject'],$_GET['condition']);
//else if($_GET['action']=='section')
//    alphabarex($cache['analyzes'],$_GET['subject'],$gconfig["color"]);
//else if($_GET['action']=='average')
//    bartutex($cache['analyzes'],$_GET['subject'],$_GET['condition'],"平均分");

//alphabarex($cache['analyzes'],"语文",$gconfig["color"]);

//alphabarex($cache['analyzes'],$gconfig['subject']);
//及格率优秀率
function bartutex($analyze,$subject,$condition,$ytitle="百分比(%)"){

    foreach($analyze as $k=>$v)
    {
        $datay[] = $v[$subject][$condition];
        $data[] = $k;
    }

    $datax = array_map("codetogbk",$data);

// Create the graph. These two calls are always required
    $graph = new Graph(300,200);
    $graph->SetScale("textlin");

// Add a drop shadow
    $graph->SetShadow();

// Adjust the margin a bit to make more room for titles
    $graph->img->SetMargin(40,30,20,40);

// Create a bar pot
    $bplot = new BarPlot($datay);

    $graph->Add($bplot);
    $bplot->value->SetFormat('%d');
    $bplot->value->Show();


// Setup the titles
    $graph->title->Set(iconv("UTF-8","GB2312//IGNORE",$condition));
    $graph->yaxis->title->Set(iconv("UTF-8","GB2312//IGNORE",$ytitle));
    $graph->xaxis->SetTickLabels($datax);
    $graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);

    $graph->title->SetFont(FF_SIMSUN,FS_BOLD);
    $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
    $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);

// Display the graph
    $graph->Stroke();


}

//总分平均分 及格率 优秀率
function bartutexall($analyze,$subject,$color,$condition){

    $Metadata = array_values($analyze);
    $legend = array_keys($analyze);
    $datax = array_map("codetogbk",array_keys($subject));
    $leglength = count($legend);
    $height = 250;
    $marginbtm = 40;

// Create the basic graph

    $img_width = One_Width*$leglength*(count($subject)+1);

    if($leglength>5){
        $addedH = ceil($leglength/5)*30;
        $height = 250 + $addedH;
        $marginbtm+=$addedH;
    }

    $graph = new Graph($img_width,$height,'auto');
    $graph->SetScale("textlin");
    $graph->img->SetMargin(40,40,40,$marginbtm);

// Adjust the position of the legend box
    $graph->legend->Pos(0.05,0.9,'left');
    $graph->legend->SetColumns(5);
    $graph->legend->SetLayout($leglength>5?LEGEND_VERT:LEGEND_HOR);
// Adjust the color for theshadow of the legend
//$graph->legend->SetShadow('darkgray@0.5');
    $graph->legend->SetFillColor('lightblue@0.3');
    $graph->legend->SetFont(FF_SIMSUN,FS_BOLD);
// Get localised version of the month names
    $graph->xaxis->SetTickLabels($datax);

// Set a nice summer (in Stockholm) image
//$graph->SetBackgroundImage('stship.jpg',BGIMG_COPY);

// Set axis titles and fonts

    $graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);


    $graph->yaxis->SetFont(FF_FONT1,FS_BOLD);


//$graph->ygrid->Show(false);
    $graph->ygrid->SetColor('white@0.5');

// Setup graph title
    $graph->title->Set(iconv("UTF-8","GB2312//IGNORE","各科各班".$condition));
// Some extra margin (from the top)
    $graph->title->SetMargin(3);
    $graph->title->SetFont(FF_SIMSUN,FS_BOLD);
    $graph->yaxis->title->Set(iconv("UTF-8","GB2312//IGNORE",$condition=="总分平均分"?"分数":"百分比(%)"));
    $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
    foreach($Metadata as $k=>$v)
    {
        $datay[$k] = array_column($v,$condition);
        $bplot[$k] = new BarPlot($datay[$k]);
        $bplot[$k]->SetFillColor(array_rand($color).'@0.4');
        $bplot[$k]->SetLegend(iconv("UTF-8","GB2312//IGNORE",$legend[$k]));
        $bplot[$k]->SetShadow('black@0.4');
    }

    $gbarplot = new GroupBarPlot($bplot);
    $gbarplot->SetWidth(0.6);
    $graph->Add($gbarplot);
//    foreach($bplot as $v)
//    {
//        $v->value->SetFormat('%d');
//        $v->value->SetFont(FF_ARIAL,FS_NORMAL,8);
//        $v->value->Show();
//    }

    //$graph->Stroke();

    if($condition=="及格率")
    {
        $savepath = "image/"."jige.jpg";
    }
    else if($condition=="优秀率")
    {
        $savepath = "image/"."youxiu.jpg";
    }
    else
    {
        $savepath = "image/"."average.jpg";
    }

    $graph->Stroke($savepath);


}

//各分段人数
function alphabarex($analyze,$thissub,$color,$filename){

    $condition= "各分段人数";

    $Metadata = array_values($analyze);
    $legend = array_keys($analyze);
    $subanalyze = $Metadata[0][$thissub];
    $leglength = count($legend);
    $height = 250;
    $marginbtm = 40;

    if($leglength>5){
        $addedH = ceil($leglength/5)*30;
        $height = 250 + $addedH;
        $marginbtm+=$addedH;
    }

    foreach($subanalyze[$condition] as $ik=>$iy)
    {
        $keyend = $ik*$subanalyze['区间'];
        $keystart = $keyend - $subanalyze['区间'];
        $datax[] = $keystart."-".$keyend;
    }


// Create the basic graph
    $img_width = 22*$leglength*count($datax)+120;
    $graph = new Graph($img_width,$height,'auto');
    $graph->SetScale("textlin");
    $graph->img->SetMargin(60,60,30,$marginbtm);

// Adjust the position of the legend box
    $graph->legend->Pos(0.05,0.9,'left');
    $graph->legend->SetColumns(5);
    $graph->legend->SetLayout($leglength>5?LEGEND_VERT:LEGEND_HOR);
// Adjust the color for theshadow of the legend
//$graph->legend->SetShadow('darkgray@0.5');
    $graph->legend->SetFillColor('lightblue@0.3');
    $graph->legend->SetFont(FF_SIMSUN,FS_BOLD);
// Get localised version of the month names
    $graph->xaxis->SetTickLabels($datax);

// Set a nice summer (in Stockholm) image
//$graph->SetBackgroundImage('stship.jpg',BGIMG_COPY);

// Set axis titles and fonts

    $graph->xaxis->SetFont(FF_FONT1,FS_BOLD);


    $graph->yaxis->SetFont(FF_FONT1,FS_BOLD);


//$graph->ygrid->Show(false);
    $graph->ygrid->SetColor('white@0.5');

// Setup graph title
    $graph->title->Set(iconv("UTF-8","GB2312//IGNORE",$thissub.$condition));
// Some extra margin (from the top)
    $graph->title->SetMargin(3);
    $graph->title->SetFont(FF_SIMSUN,FS_BOLD);
    $graph->yaxis->title->Set(iconv("UTF-8","GB2312//IGNORE","人数"));
    $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD,12);
    foreach($Metadata as $k=>$v)
    {
        $datay[$k] = array_values($v[$thissub][$condition]);
        $bplot[$k] = new BarPlot($datay[$k]);
        $bplot[$k]->SetFillColor(array_rand($color).'@0.4');
        $bplot[$k]->SetLegend(iconv("UTF-8","GB2312//IGNORE",$legend[$k]));
        $bplot[$k]->SetShadow('black@0.4');
    }

    $gbarplot = new GroupBarPlot($bplot);
    $gbarplot->SetWidth(0.6);
    $graph->Add($gbarplot);
    foreach($bplot as $v)
    {
        $v->value->SetFormat('%d');
        $v->value->SetFont(FF_ARIAL,FS_NORMAL,8);
        $v->value->Show();
    }

    $graph->Stroke($filename);


}

function codetogbk($n)
{
    return iconv("UTF-8","GB2312//IGNORE",$n);
}
