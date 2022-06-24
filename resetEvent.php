<?php
function isExist($key_arr, $tar): bool
{
    foreach ($key_arr as $key) {
        if (!array_key_exists($key, $tar)) {
            return false;
        }
    }
    return true;
}

function pop($display, $locate): void
{
    echo "<script>";
    echo "alert('$display');";
    echo "window.location.replace('$locate');";
    echo "</script>";
}

$keys = array('uid', 'phone', 'atcode', 'pwd_new1', 'pwd_new2');
if (!isExist($keys, $_POST)) {
    pop("请确认是否填写完成！", "reset.php");
    return;
}
$uid = $_POST['uid'];
$phone = $_POST['phone'];
$atcode = $_POST['atcode'];
$pwd_new1 = $_POST['pwd_new1'];
$pwd_new2 = $_POST['pwd_new2'];

$mode = "";
$tb = "";
$idNum = strlen($uid);
if (!is_numeric($uid)) {
    pop("用户ID必须为数字！", "reset.php");
    return;
}

if ($idNum == 12) {
    $mode = "STU";
    $tb = "student";
    $tb1 = "sid";
    $tb2 = "sname";
    $tb3 = "scollege";
    $tb4 = "sphone";
    $tb5 = "ssex";
} elseif ($idNum == 10) {
    $mode = "TEC";
    $tb = "teacher";
    $tb1 = "tid";
    $tb2 = "tname";
    $tb3 = "tcollege";
    $tb4 = "tphone";
    $tb5 = "tsex";
} else {
    pop("用户ID长度错误！学生应为12位，教师应为10位。", "reset.php");
    return;
}

if (strlen($phone) != 11) {
    pop("手机号码格式错误，请重新输入。", "reset.php");
}
if ($atcode != "0000") {
    pop("验证码错误，请重新输入。", "reset.php");
}

if ($pwd_new1 !== $pwd_new2) {
    pop("两次密码不一致，请重新输入。", "reset.php");
}
$connect = new mysqli("localhost:3306", "root", "12345678");
if ($connect->connect_error) {
    die("Connect failed:" . $connect->connect_error);
}

$connect->select_db("eas");

$stmt = $connect->prepare("SELECT uid FROM user WHERE uid = ?");
$stmt->bind_param("s", $uid);
$stmt->bind_result($selectuid);

$stmt->execute();
$stmt->store_result();

if (!$stmt->fetch()) {
    $stmt->close();
    pop("此用户ID未被注册，请先注册！", "register.php");
    return;
} else {
    $stmt->close();

    $stmt = $connect->prepare("SELECT $tb4 FROM $tb WHERE {$tb1} =  ? AND {$tb4} = ?");
    $stmt->bind_param("ss", $uid, $phone);
    $stmt->bind_result($selectphone);


    $stmt->execute();
    $stmt->store_result();

    if (!$stmt->fetch()) {
        $stmt->close();
        pop("未设置手机号，或输入错误", "reset.php");
        return;
    }
    $pwd = hash("sha1", $pwd_new1);
    $stmt = $connect->prepare("UPDATE user SET pwd = ? WHERE uid = ? ");
    $stmt->bind_param("ss", $pwd, $uid);
    $stmt->execute();

    $judge = $stmt->store_result();
    $stmt->close();
    if ($judge) {
        pop("重置成功！", "index.php");
    } else {
        $err = $connect->error;
        $err_msg = "错误 " . $err;
        pop($err_msg, "reset.php");
    }

}
$connect->close();
