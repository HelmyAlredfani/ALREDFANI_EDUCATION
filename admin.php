<?php
session_start();

$admin_username = "alredfani";
$admin_password = "7334573345";

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "بيانات الدخول غير صحيحة";
    }
}

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="ar">
    <head>
      <meta charset="utf-8">
      <title>تسجيل دخول الإدارة</title>
    </head>
    <body>
      <h3>دخول الإدارة لإدخال النتائج</h3>
      <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
      <form action="admin.php" method="post">
        <label>اسم المستخدم:</label>
        <input type="text" name="username" required>
        <br>
        <label>كلمة المرور:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit" name="login">تسجيل الدخول</button>
      </form>
    </body>
    </html>
    <?php
    exit();
}

if (isset($_POST['submit_result'])) {
    $student_name = $_POST['student_name'] ?? '';
    $exam_number  = $_POST['exam_number'] ?? '';
    $result       = $_POST['result'] ?? '';
    $year         = $_POST['year'] ?? '';

    if (!empty($student_name) && !empty($exam_number) && !empty($result) && !empty($year)) {
        $file = 'results.csv';
        $fp = fopen($file, 'a');
        if ($fp) {
            $data = [$year, $exam_number, $student_name, $result];
            fputcsv($fp, $data);
            fclose($fp);
            $message = "تم إدخال النتيجة بنجاح.";
        } else {
            $message = "فشل فتح الملف لتخزين البيانات.";
        }
    } else {
        $message = "يرجى تعبئة جميع الحقول.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="utf-8">
  <title>لوحة الإدارة - إدخال نتائج الطلاب</title>
</head>
<body>
  <h3>إدخال نتائج الطلاب</h3>
  <?php if(isset($message)) echo "<p style='color:blue;'>$message</p>"; ?>
  <form action="admin.php" method="post">
    <label>العام الدراسي:</label>
    <input type="text" name="year" required>
    <br>
    <label>رقم الجلوس:</label>
    <input type="number" name="exam_number" required>
    <br>
    <label>اسم الطالب:</label>
    <input type="text" name="student_name" required>
    <br>
    <label>النتيجة:</label>
    <input type="text" name="result" required>
    <br>
    <button type="submit" name="submit_result">إدخال النتيجة</button>
  </form>
  <br>
  <a href="logout.php">تسجيل الخروج</a>
</body>
</html>
