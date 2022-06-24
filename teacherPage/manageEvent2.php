<?php
function pop($display, $locate)
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

if (!(isset($_POST['sid']) and isset($_POST['score']) and isset($_POST['manage']))) {
    pop("信息缺失！", "manageEvent.php");
    return;
}

$qy = "";
foreach ($_POST['sid'] as $key => $value) {
    $score = "";
    if (!(is_numeric($_POST['score'][$key]) or empty($_POST['score'][$key]))) {
        pop("分数必须是数字！", "manageEvent.php");
        return;
    }

    if (empty($_POST['score'][$key])) {
        $score = "NULL";
    } else {
        $score = $_POST['score'][$key];
    }

    if ($score != "NULL" and ($score > 100 or $score < 0)) {
        pop("分数必须在0~100之间！", "manageEvent.php");
        return;
    }

    $qy .= "UPDATE chosedcourse SET score = {$score} WHERE cid = '{$_POST['manage']}' AND sid = '{$value}';";
}

if ($connect->multi_query($qy) === TRUE) {
    pop("成绩更新完成！", "manageEvent.php");
} else {
    pop($connect->error, "manageEvent.php");
}

$connect->close();
