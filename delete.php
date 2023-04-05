<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
    header("Location: login.php");
    exit();
}
if(isset($_POST['id']) && !empty($_POST['id'])) {
    $db = new SQLite3('reports.db');
    $id = $_POST['id'];
    $stmt = $db->prepare('DELETE FROM reports WHERE id = :id');
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if($result){
        echo "<p>删除成功！</p>";
    }else{
        echo "<p>删除失败，请稍后再试。</p>";
    }

    $db->close();
} else {
    echo "<p>没有指定要删除的记录。</p>";
}

// 返回到检测报告查询页面
header("Location: search.php");
exit();
?>
