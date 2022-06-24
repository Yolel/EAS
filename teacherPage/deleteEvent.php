<?php
function pop($display, $locate): void
{
    echo "<script>";
    echo "alert('{$display}');";
    echo "window.location.replace('{$locate}');";
    echo "</script>";
}

$connect = new mysqli("localhost:3306", "root", "12345678");
if ($connect->connect_error) {
    die("Connect failed:" . $connect->connect_error);
}
$connect->select_db("eas");

if (!isset($_COOKIE['uid'])) {
    pop("cookie已失效,请重新登录", "../index.php");
}

if (!isset($_POST['manage'])) {
    pop("信息缺失！", "manageProcess.php");
    return;
}

$qy = "DELETE FROM course WHERE cid = '{$_POST['manage']}'";
if ($connect->query($qy) === TRUE) {
    pop("删除成功！", "teacherManage.php");
} else {
    pop($connect->error, "teacherManage.php");
}
