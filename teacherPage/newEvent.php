<?php
function pop($display, $locate): void
{
    echo "<script>";
    echo "alert('{$display}');";
    echo "window.location.replace('{$locate}');";
    echo "</script>";
}

$connect = new mysqli("localhost:3306", "uTEC", "teacher");
if ($connect->connect_error) {
    die("Connect failed:" . $connect->connect_error);
}
$connect->select_db("eas");

if (!isset($_COOKIE['uid'])) {
    pop("cookie已失效,请重新登录", "../index.php");
    return;
}

if (!(isset($_POST['cid']) and isset($_POST['cname']) and isset($_POST['credit']) and isset($_POST['day']))) {
    pop("输入信息不全！", "teacherNew.php");
    return;
}

if (strlen($_POST['cid']) == 0 or strlen($_POST['cname']) == 0 or strlen($_POST['credit']) == 0 or strlen($_POST['day']) == 0) {
    pop("输入不能为空！", "teacherNew.php");
    return;
}

$qy = "SELECT * FROM course WHERE cid = '{$_POST['cid']}'";
$rec = $connect->query($qy);
if ($rec->fetch_array(MYSQLI_ASSOC)) {
    pop("课程代码已经存在！", "teacherNew.php");
    return;
}

$qy = "INSERT INTO course VALUES ('{$_POST['cid']}', '{$_POST['cname']}', '{$_COOKIE['uid']}', '{$_POST['credit']}','{$_POST['day']}');";

$rec = $connect->query($qy);
if ($rec) {
    pop("添加课程成功！", "teacherNew.php");
} else {
    pop($connect->error, "teacherNew.php");
}
