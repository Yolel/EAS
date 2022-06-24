<?php
function pop($display, $locate)
{
    echo "<script>";
    echo "alert('{$display}');";
    echo "window.location.replace('{$locate}');";
    echo "</script>";
}

$connect = new mysqli("localhost:3306", "uSTU", "student");
if ($connect->connect_error) {
    die("Connect failed:" . $connect->connect_error);
}
$connect->select_db("eas");

if (!isset($_COOKIE['uid'])) {
    pop("登录已过期，或你的浏览器不支持cookie！", "../index.php");
}

$uid = $_COOKIE['uid'];

$qy = "";
if (!isset($_POST['cancel'])) {
    pop("请选择要撤掉的课程！", "studentCancel.php");
} else {
    foreach ($_POST['cancel'] as $key => $value) {
        $qy .= "DELETE FROM chosedcourse WHERE sid = '{$uid}' AND cid = '{$value}';";
    }
    if ($connect->multi_query($qy) === TRUE) {
        pop("撤销课程成功！", "studentCancel.php");
    } else {
        pop($connect->error, "studentCancel.php");
    }
}