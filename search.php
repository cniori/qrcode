<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    header("Location: login.php");
    exit();
}

$db = new SQLite3('reports.db');
$page_size = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$count = $db->querySingle('SELECT COUNT(*) FROM reports');
$total_pages = ceil($count / $page_size);

$offset = ($page - 1) * $page_size;

$stmt = $db->prepare('SELECT * FROM reports LIMIT :offset, :limit');
$stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
$stmt->bindValue(':limit', $page_size, SQLITE3_INTEGER);
$results = $stmt->execute();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./src/style.css">
	<title>检测报告查询</title>
</head>
<h1>检测报告查询结果</h1>
<table id="table-3">
  <tr>
    <th>ID</th>
    <th>报告编号</th>
    <th>受检单位名称</th>
    <th>检测项目名称</th>
    <th>项目类型</th>
    <th>检测类型</th>
    <th>检测日期</th>
    <th>下次检测日期</th>
    <th>操作</th>
  </tr>
  <?php while ($row = $results->fetchArray()): ?>
  <tr>
  <td><?php echo $row['id']; ?></td>
  <td><?php echo $row['report_id']; ?></td>
  <td><?php echo $row['company_name']; ?></td>
  <td><?php echo $row['project_name']; ?></td>
  <td><?php echo $row['project_type']; ?></td>
  <td><?php echo $row['test_type']; ?></td>
  <td><?php echo $row['test_date']; ?></td>
  <td><?php echo $row['next_checkDate']; ?></td>
  <td>
    <form method="POST" action="delete.php">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <input type="submit" value="删除">
    </form>
  </td>
</tr>
  <?php endwhile; ?>
</table>
<div class="pagination">
  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <?php if ($i == $page): ?>
      <span class="current"><?php echo $i; ?></span>
    <?php else: ?>
      <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endif; ?>
  <?php endfor; ?>
</div>
<?php
$db->close();
?>
</body>
</html>
