<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/9
 * Time: 17:43
 */
//print_r(range(0,150,20));
//测试git
require "config.php";
require_once ('lib/jpgraph/jpgraph.php');
require_once ('lib/jpgraph/jpgraph_bar.php');
$cache = unserialize(file_get_contents($gconfig["cache"]));

// Some data
$Metadata = array_values($cache['analyzes']);
$thissub = "语文";
$condition= "各分段人数";
$color = $gconfig["color"];
$legend = array_keys($cache['analyzes']);
$subanalyze = $Metadata[0][$thissub];
foreach($subanalyze[$condition] as $ik=>$iy)
{
    $keyend = $ik*$subanalyze['区间'];
    $keystart = $keyend - $subanalyze['区间'];
    $datax[] = $keystart."-".$keyend;
}


// Create the basic graph
$graph = new Graph(450,250,'auto');
$graph->SetScale("textlin");
$graph->img->SetMargin(40,80,30,40);

// Adjust the position of the legend box
$graph->legend->Pos(0.2,0.88);

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
$graph->title->SetFont(FF_SIMSUN,FS_BOLD,12);

//// Create the three var series we will combine
//$bplot1 = new BarPlot($datay1);
//$bplot2 = new BarPlot($datay2);
//$bplot3 = new BarPlot($datay3);
//
//// Setup the colors with 40% transparency (alpha channel)
//$bplot1->SetFillColor('orange@0.4');
//$bplot2->SetFillColor('brown@0.4');
//$bplot3->SetFillColor('darkgreen@0.4');
//
//// Setup legends
//$bplot1->SetLegend('Label 1');
//$bplot2->SetLegend('Label 2');
//$bplot3->SetLegend('Label 3');
//
//// Setup each bar with a shadow of 50% transparency
//$bplot1->SetShadow('black@0.4');
//$bplot2->SetShadow('black@0.4');
//$bplot3->SetShadow('black@0.4');
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

$graph->Stroke();
