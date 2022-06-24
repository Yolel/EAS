<body>
<?php
function pop($display, $locate): void
{
    echo "<script>";
    echo "alert('$display');";
    echo "window.location.replace('$locate');";
    echo "</script>";
}

function confirm_window($display, $locate_1, $locate_2): void
{
    echo "<script>";
    echo "if (confirm('$display')) { window.location.replace('$locate_1'); }";
    echo "else { window.location.replace('$locate_2'); }";
    echo "</script>";
}

if ($_POST['acode'] === "0030") {
    $connect = new mysqli("localhost:3306", "root", "12345678");
    if ($connect->connect_error) {
        die("Connect failed:" . $connect->connect_error);
    }
    $connect->select_db("eas");

    $tar_web = "#";
    $tar_uid = "";
    $tar_pwd = "";

    if (isset($_POST['uid'])) {
        $uid = $_POST['uid'];

        $stmt = $connect->prepare("SELECT mode, pwd FROM user WHERE uid = ?");
        $stmt->bind_param("s", $uid);
        $stmt->bind_result($select_mode, $select_pwd);

        $stmt->execute();
        $stmt->store_result();
        if ($stmt->fetch()) {
            $pwd = hash("sha1", $_POST['pwd']);
            $tar_pwd = $pwd;

            if ($pwd == $select_pwd) {
                $tar_uid = $uid;
                switch ($select_mode) {
                    case "STU":
                        $tar_web = "studentPage/studentIndex.php";
                        break;
                    case "TEC":
                        $tar_web = "teacherPage/teacherIndex.php";
                        break;
                    default:
                }
                setcookie("uid", $tar_uid, time() + 60 * 30);
            } else {
                pop("密码错误，请重试！", "index.php");
            }
        } else {
            confirm_window("用户不存在，请先注册！", "register.php", "index.php");
        }
        $stmt->close();
    } else {
        pop("请从登录页面进入！", "index.php");
    }
    $connect->close();
} else {
    pop("验证码输入错误，请重新输入！", "index.php");
}
?>

<form action="<?php echo $tar_web; ?>" method="post" id="form1">
    <input type="hidden" name="usr_pwd" value="<?php echo $tar_pwd; ?>">
    <input type="hidden" name="from" value="from_login">
</form>
<script>
    let form = document.getElementById('form1');
    let ele = form.getElementsByTagName('input');
    if (ele['usr_pwd'].length !== 0) {
        form.submit();
    }
</script>

</body>

