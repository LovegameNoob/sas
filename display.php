<?php
/**
 * 展示分析得到的数据(综合分析对比统计图)
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/13
 * Time: 11:00
 */

require "config.php";
require_once "chart.php";
$cache = unserialize(file_get_contents($gconfig["cache"]));
$subject = array_keys($gconfig['subject']);
createchart($cache['analyzes'],$gconfig['subject'],$gconfig["color"]);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>学生成绩分析结果展示</title>
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/datatables/css/dataTables.bootstrap.css">
    <script type="text/javascript" src="public/datatables/js/jquery.js"></script>
    <script type="text/javascript" src="public/datatables/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="public/datatables/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="public/js/comdisplay.js"></script>
</head>
<body>
<div class="container">
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">综合分析</h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs" role="tablist" id="mytabs">
                <li role="presentation"  class="active"><a href="#passratio" aria-controls="#passratio" role="tab" data-toggle="tab">及格率</a></li>
                <li role="presentation"><a href="#fineratio" aria-controls="#fineratio" role="tab" data-toggle="tab">优秀率</a></li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        各分段人数 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach($subject as $ak=>$av){ ?>
                            <li role="presentation"><a href="#tab<?php echo $ak;?>" aria-controls="#tab<?php echo $ak;?>" role="tab" data-toggle="tab"><?php echo $av;?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li role="presentation"><a href="#average" aria-controls="#average" role="tab" data-toggle="tab">总分平均分</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="passratio">
                    <img src="image/jige.jpg"  alt="及格率">
                </div>
                <div role="tabpanel" class="tab-pane" id="fineratio">
                    <img src="image/youxiu.jpg"  alt="优秀率">
                </div>
                <?php foreach($subject as $ak=>$av){ ?>
                <div role="tabpanel" class="tab-pane" id="tab<?php echo $ak;?>">
                    <img src="image/section<?php echo $ak;?>.jpg"  alt="<?php echo $av;?>各分段人数">
                </div>
                <?php } ?>
                <div role="tabpanel" class="tab-pane" id="average">
                    <img src="image/average.jpg"  alt="总分平均分">
                </div>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>姓名</th>
                <?php foreach($subject as $ak=>$av){ ?>
                    <th><?php echo $av;?></th>
                <?php } ?>
                <th>总分</th>
                <th>班级</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($cache['allstudent'] as $stuk=>$stuv){ ?>
                <tr>
                    <?php foreach($stuv as $subk=>$subv){ ?>
                        <td><?php echo $subv;?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <a href="export.php" class="btn btn-primary">导出分析结果</a>
</div>
</body>
</html>

