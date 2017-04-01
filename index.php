<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生成绩分析</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
<div class="main">
    <div class="form-doc">
        <form action="reader.php" method="post" enctype="multipart/form-data">
            <label for="scorelist">成绩单:</label>
            <input type="file" name="file" id="scorelist"/>
            <input type="submit" name="submit" value="提交"/>
        </form>
    </div>
    <div id="preloader_4">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<script type="text/javascript" src="public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="public/js/js.js"></script>
<script>
    $(':submit').click(function(){$("#preloader_4").show()})
</script>
</body>
</html>