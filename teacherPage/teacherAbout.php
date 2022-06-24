<head>
    <title>教师信息</title>
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
    echo "教师编号：{$row['tid']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>";
    echo "<br>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：<input type='text' style='border-bottom: none;width: 140px' name='tid[]' value='{$row['tname']}' autocomplete='off'><br>";
    echo "性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：";
    if ($row['tsex'] == "male") {
        echo "<input type='text' style='border-bottom: none;width: 140px;' name='tid[]' value='男' autocomplete='off'><br>";
    } else {
        echo "<input type='text' name='tid[]' style='border-bottom: none;width: 140px;' value='男' autocomplete='off'><br>";
    }
    if ($row['tphone'] == null)
        $phone = "尚未绑定手机号";
    else
        $phone = $row['tphone'];
    echo "<br>手机号码：<input type='text' style='border-bottom: none;width: 140px' name='tid[]' value='{$phone}' autocomplete='off'><br>";
    echo "所属院系：<input type='text' style='width: 140px' name='tid[]' value='{$row['tcollege']}' autocomplete='off'><br>";
    echo "<br>";
    $year0 = substr($row['tid'], 0, 4);
    echo "任职年度：{$year0}<br>";
    $now = new DateTime();
    $year = $now->format("Y");
    $bias = $year - (int)$year0;
    echo "任职年数：{$bias}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
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

$connect = new mysqli("localhost:3306", "uTEC", "teacher");
if ($connect->connect_error) {
    die("Connect failed:" . $connect->connect_error);
}
$connect->select_db("eas");

if (!isset($_COOKIE['uid'])) {
    pop("cookie已失效,请重新登录", "../index.php");
    return;
}

$uid = $_COOKIE['uid'];

if (strlen($uid) != 10) {
    pop("用户ID非教师ID！", "../index.php");
    return;
}

$rec = $connect->query("SELECT tname FROM teacher WHERE tid = '{$uid}'");
$row = $rec->fetch_array(MYSQLI_ASSOC);

$user_name = $row['tname'];

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
                SELECT * FROM teacher WHERE tid = '{$uid}';
            QUERY;
            $rec = $connect->query($qy);
            putTable($rec);
            ?>
        </div>
    </main>
    <sidebar>
        <div class="logo">教师端</div>
        <div class="avatar">
            <div class="avatar__img">
                <img src="../static/images/headTEC.png" alt="个人信息">
            </div>
            <div class="avatar__name">
                <?php echo $user_name; ?>
            </div>
        </div>
        <nav class="menu">
            <a class="menu__item" href="teacherIndex.php">
                <span class="menu__text">已开课程</span>
            </a>
            <a class="menu__item" href="teacherNew.php">
                <span class="menu__text">新开课程</span>
            </a>
            <a class="menu__item" href="teacherManage.php">
                <span class="menu__text">管理课程</span>
            </a>
            <a class="menu__item menu__item--active" href="#">
                <span class="menu__text">教师信息</span>
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
        <div class="copyright">&copy;Made by yolel 2022</div>
    </sidebar>
</div>
</body>
