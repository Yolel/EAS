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

$keys = array('uid', 'pwd', 'name', 'sex', 'college');
if (!isExist($keys, $_POST)) {
    pop("请确认是否填写完成！", "register.php");
    return;
}

$connect = new mysqli("localhost:3306", "root", "12345678");
if ($connect->connect_error) {
    die("Connect failed:" . $connect->connect_error);
}

$connect->select_db("eas");

$uid = $_POST['uid'];
$pwd = $_POST['pwd'];
$name = $_POST['name'];
$sex = $_POST['sex'];
$college = $_POST['college'];

$stmt = $connect->prepare("SELECT uid FROM user WHERE uid = ?");
$stmt->bind_param("s", $uid);
$stmt->bind_result($selectuid);

$stmt->execute();
$stmt->store_result();

if ($stmt->fetch()) {
    $stmt->close();
    pop("此用户ID已被注册，请重新注册！", "register.php");
    return;
} else {
    $stmt->close();

    $mode = "";
    $tb = "";
    $idNum = strlen($uid);

    if (!is_numeric($uid)) {
        pop("用户ID必须为数字！", "register.php");
        return;
    }

    if ($idNum == 12) {
        $mode = "STU";
        $tb = "student";
        $tb1 = "sid";
        $tb2 = "sname";
        $tb3 = "scollege";
        $tb4 = "ssex";
    } elseif ($idNum == 10) {
        $mode = "TEC";
        $tb = "teacher";
        $tb1 = "tid";
        $tb2 = "tname";
        $tb3 = "tcollege";
        $tb4 = "tsex";
    } else {
        pop("用户ID长度错误！学生应为12位，教师应为10位。", "register.php");
        return;
    }

    $pwd = hash("sha1", $pwd);

    $stmt = $connect->prepare("INSERT INTO user VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $uid, $pwd, $mode);
    $stmt->execute();

    if ($stmt->store_result()) {
        $stmt->close();

        $stmt = $connect->prepare("INSERT INTO {$tb}($tb1,$tb2,$tb3,$tb4) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $uid, $name, $college, $sex);
        $stmt->execute();

        $judge = $stmt->store_result();
        $stmt->close();
        if ($judge) {
            pop("注册成功！", "index.php");
        } else {
            $err = $connect->error;
            $connect->query("DELETE FROM user WHERE uid = '{$uid}'");
            $err_msg = "错误 " . $err;
            pop($err_msg, "register.php");
        }
    } else {
        $stmt->close();
        $err = $connect->error;
        $err_msg = "错误 " . $err;
        pop($err_msg, "register.php");
    }

}

$connect->close();
