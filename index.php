<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./src/style.css">
    <title>防雷检测报告二维码生成页面</title>
</head>
<body>
   
    <form method="post" action="" class="smart-green">
        <h1>防雷检测报告二维码生成系统
        <span>请完整填写所有信息.</span>
    </h1>
        <label>检测报告编号：</label>
        <input type="text" name="report_id" required><br><br>
        <label>受检单位名称：</label>
        <input type="text" name="company_name" required><br><br>
        <label>检测项目名称：</label>
        <input type="text" name="project_name" required><br><br>
        <label>项目类型：</label>
        <input type="radio" name="project_type" value="定期检测">定期检测
        <input type="radio" name="project_type" value="新建检测"><span style="margin-right:20px;">新建检测</span>
        <label>检测类型：</label>
        <input type="radio" name="test_type" value="一般性检测">一般性检测
        <input type="radio" name="test_type" value="易燃易爆检测"><span style="margin-right:20px;">易燃易爆检测</span>
        <label>检测日期：</label>
        <input type="date" name="test_date"><br><br>
        <input type="submit" name="submit" class="button" value="生成二维码">
        <input type="reset" class="button" value="重置">
    </form>
    <div align="center" id="status-bar"></div> <!-- new status bar element -->
    
<?php
require_once "phpqrcode.php";
require_once "./src/qr.php";
require_once "./src/db.php"; // include DBHandler class file

if(isset($_POST['submit'])){
    $report_id = trim($_POST['report_id']);
    $company_name = trim($_POST['company_name']);
    $project_name = trim($_POST['project_name']);
    $project_type = $_POST['project_type'];
    $test_type = $_POST['test_type'];
    $test_date = $_POST['test_date'];

    //检查用户输入
    if(empty($report_id) || empty($company_name) || empty($project_name) || empty($project_type) || empty($test_type) || empty($test_date)) {
        echo "<script>document.getElementById('status-bar').innerHTML += '请完整填写所有信息';</script>";
    } else {

        //判断下次检测日期
        if($test_type == "易燃易爆检测"){
            $next_checkDate = date('Y-m-d', strtotime($test_date. ' + 6 months'));
        } else {
            $next_checkDate = date('Y-m-d', strtotime($test_date. ' + 12 months'));
        }

        //创建DBHandler对象并连接数据库
        $db_handler = new DBHandler('reports.db');

        //检查是否有重复的记录
        $is_duplicate = $db_handler->checkDuplicate($report_id);

        if($is_duplicate) {
            echo "<script>document.getElementById('status-bar').innerHTML += '编号重复，请检查！';</script>";
        } else {
            //插入数据
            $result = $db_handler->insertRecord($report_id, $company_name, $project_name, $project_type, $test_type, $test_date, $next_checkDate);

            if($result){
                echo "<script>document.getElementById('status-bar').innerHTML += '生成二维码成功';</script>";
            } else {
                echo "<script>document.getElementById('status-bar').innerHTML += '生成二维码失败';</script>";
            }
        }

        //关闭数据库连接
        unset($db_handler);
    }
}

if(isset($result) && $result){
    //拼接二维码字段内容
    $data = "http://2wm.gdfljc.com/query.php?report_id=".$report_id;

    //生成二维码
    $filename = generateQRCodeWithLogo($data,$report_id);

    //显示二维码
    echo "<img src='$filename' style='display:block; margin:0 auto;'>";
}
?>

</body>
</html>
