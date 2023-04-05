<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>检测报告查询</title>
  <style style= "text/css">
    table {
      max-width: 760px;
      margin: auto;
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      text-align: left;
      padding: 8px;
    }
    td.a {
      width: 120px;
      text-align: right;
    }

    tr:nth-child(even){
      background-color: #f2f2f2
    }

    th {
      background-color: #4CAF50;
      color: white;
    }
        /* box-shadow 电子签章 */
        .circle{
            margin: 50px auto;
            width:46px;
            height: 46px;
            line-height: 25px;
            padding: 25px;
            color:#ff0000;
            font-weight: bold;
            text-align: center;
            word-break: break-all;
            border-radius: 50%;
            background-color: #fff;
            box-shadow: 0 0 0 2px #ff0000, 0 0 0 8px #ff0000 ;
            font-size: 23px;
               }
  </style>
</head>
<body>
<?php
$report_id = trim($_GET['report_id']);
//连接数据库
$db = new SQLite3('reports.db');
//查询数据
$results = $db->query("SELECT * FROM reports WHERE report_id='$report_id'");
if($row = $results->fetchArray()){
  echo "<table>";
  echo "<tr><th colspan='2'>您查询的《广东省雷电防护装置检测报告》结果如下：</th></tr>";
  echo "<tr><td class=a>检测报告编号:</td><td>".$row['report_id']."</td></tr>";
  echo "<tr><td class=a>受检单位名称:</td><td>".$row['company_name']."</td></tr>";
  echo "<tr><td class=a>检测项目名称:</td><td>".$row['project_name']."</td></tr>";
  echo "<tr><td class=a>项目类型:</td><td>".$row['project_type']."</td></tr>";
  echo "<tr><td class=a>检测类型:</td><td>".$row['test_type']."</td></tr>";
  echo "<tr><td class=a>检测日期:</td><td>".date("Y年m月d日", strtotime($row['test_date']))."</td></tr>";
  echo "<tr><td class=a>下次检测日期:</td><td>".date("Y年m月d日", strtotime($row['next_checkDate']))."前</td></tr>";
  echo "<tr><td class=a>检测单位:</td><td>南京绝缘体防雷检测有限公司</td></tr>";
  echo "<tr><td class=a>检测结论:</td><td>经检测，被检建（构）筑物本次所检项目符合检测依据的要求。</td></tr>";
  echo "</table>";
  echo "<div class=circle>查询通过</div> ";
}
else {
  echo "<div class=circle>无效查询</div>" ;

}
//关闭数据库连接
$db->close();
?>
</body>
</html>
