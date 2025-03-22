<?php
$results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['search'] ?? '';
    $file = 'results.csv';
    if (file_exists($file)) {
        $fp = fopen($file, 'r');
        while (($data = fgetcsv($fp)) !== false) {
            if ($data[1] == $search || stripos($data[2], $search) !== false) {
                $results[] = $data;
            }
        }
        fclose($fp);
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="utf-8">
  <title>نتائج الطلاب</title>
</head>
<body>
  <h3>بحث عن نتيجة الطالب</h3>
  <form action="public_results.php" method="post">
    <label>ادخل اسم الطالب أو رقم الجلوس:</label>
    <input type="text" name="search" required>
    <button type="submit">بحث</button>
  </form>
  <br>
  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (count($results) > 0) {
          echo "<table border='1'>";
          echo "<tr><th>العام الدراسي</th><th>رقم الجلوس</th><th>اسم الطالب</th><th>النتيجة</th></tr>";
          foreach ($results as $row) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row[0]) . "</td>";
              echo "<td>" . htmlspecialchars($row[1]) . "</td>";
              echo "<td>" . htmlspecialchars($row[2]) . "</td>";
              echo "<td>" . htmlspecialchars($row[3]) . "</td>";
              echo "</tr>";
          }
          echo "</table>";
      } else {
          echo "<p>لا توجد نتائج مطابقة.</p>";
      }
  }
  ?>
</body>
</html>
