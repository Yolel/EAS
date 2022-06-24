<head>
    <title>学生端</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../static/css/user.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../static/images/favicon.ico">
</head>

<body>
<?php
function putTable($rec)
{
    $row = $rec->fetch_array(MYSQLI_ASSOC);
    echo "<br>";
    echo "<form>";
    echo "<div class='smoothbox'>";
    echo "学生学号：{$row['sid']}&nbsp;&nbsp;&nbsp;&nbsp;<br>";
    echo "<br>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：<input type='text' style='border-bottom: none;width: 140px' name='tid[]' value='{$row['sname']}' autocomplete='off'><br>";
    echo "性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：";
    if ($row['ssex'] == "male") {
        echo "<input type='text' style='border-bottom: none;width: 140px;' name='tid[]' value='男' autocomplete='off'><br>";
    } else {
        echo "<input type='text' name='tid[]' style='border-bottom: none;width: 140px;' value='男' autocomplete='off'><br>";
    }
    if ($row['sphone'] == null)
        $phone = "尚未绑定手机号";
    else
        $phone = $row['sphone'];
    echo "<br>手机号码：<input type='text' style='border-bottom: none;width: 140px' name='tid[]' value='{$phone}' autocomplete='off'><br>";
    echo "所属学院：<input type='text' style='border-bottom: none;width: 140px' name='tid[]' value='{$row['scollege']}' autocomplete='off'><br>";
    echo "<br>";
    $year0 = substr($row['sid'], 0, 4);
    echo "入学年度：{$year0}<br>";
    $now = new DateTime();
    $year = $now->format("Y");
    $uniYear = $year - (int)$year0;
    switch ($uniYear) {
        case 1:
            $phase = "大一";
            break;
        case 2:
            $phase = "大二";
            break;
        case 3:
            $phase = "大三";
            break;
        case 4:
            $phase = "大四";
            break;
        case 5:
            $phase = "大五";
            break;
        case 6:
            $phase = "大六";
            break;
        default:
            $phase = "学年录入异常";
    }

    echo "大学年级：{$phase}";
    echo "<form/>";
    echo "</div>";
}

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
    pop("cookie已失效,请重新登录", "../index.php");
    return;
}

$uid = $_COOKIE['uid'];

if (strlen($uid) != 12) {
    pop("用户ID非学生ID！", "../index.php");
    return;
}

$rec = $connect->query("SELECT sname FROM student WHERE sid = '{$uid}'");
$row = $rec->fetch_array(MYSQLI_ASSOC);

$user_name = $row['sname'];

?>
<div class="wrapper">
    <main>
        <div class="toolbar">
            <div class="smoothbox headbox" style="font-size: 35px">
                个人信息
            </div>
        </div>
        <div class="calendar">
            <?php
            $qy = <<<QUERY
                SELECT * FROM student WHERE sid = '{$uid}';
            QUERY;
            $rec = $connect->query($qy);
            putTable($rec);
            ?>
        </div>
    </main>
    <sidebar>
        <div class="logo">学生</div>
        <div class="avatar">
            <div class="avatar__img">
                <a href="studentAbout.php"><img src="../static/images/haedSTU.png" alt="avatar"></a>
            </div>
            <div class="avatar__name">
                <?php echo $user_name; ?>
            </div>
        </div>
        <nav class="menu">
            <a class="menu__item" href="studentIndex.php">
                <span class="menu__text">已选课程</span>
            </a>
            <a class="menu__item" href="studentChoose.php">
                <span class="menu__text">选择课程</span>
            </a>
            <a class="menu__item" href="studentCancel.php">
                <span class="menu__text">撤销选课</span>
            </a>
            <a class="menu__item menu__item--active" href="#">
                <span class="menu__text">个人信息</span>
            </a>
        </nav>
        <a class="icon" href="../logout.php">
            <svg width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                 stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
            </svg>
        </a>
        <div class="copyright">Copyright &copy; 2022</div>
    </sidebar>
</div>
</body>
