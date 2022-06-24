<?php
function pop($display, $locate): void
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
if (!isset($_POST['chosen'])) {
    pop("尚未选课！", "studentChoose.php");
} else {
    foreach ($_POST['chosen'] as $key => $value) {
        $qy .= "INSERT INTO chosedcourse VALUES ('{$uid}', '{$value}', NULL);";
    }
    if ($connect->multi_query($qy) === TRUE) {
        pop("选课成功！", "studentChoose.php");
    } else {
        pop($connect->error, "studentChoose.php");
    }
}