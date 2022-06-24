<head>
    <title>新开课程</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../static/css/new.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../static/images/favicon.ico">
</head>

<body>
<?php
function mapped($value): string
{
    switch ($value) {
        case "cid":
            return "课程代码";
        case "cname":
            return "课程名";
        case "tname":
            return "授课教师";
        case "tdept":
            return "开课学院";
        case "credit":
            return "学分";
        case "score":
            return "成绩";
        default:
            return "";
    }
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
            <div class="current-month" style=";font-weight: normal;font-size: 20px">
                新开课程
            </div>
            <div class="toggle">
                <div class="toggle__option" onclick="window.location.replace('teacherNew.php')">取消</div>
                <div class="toggle__option" onclick="document.getElementById('newCourse').submit()">提交</div>
            </div>
        </div>
        <div class="calendar" style="display: block;position: absolute;left: 40%">
            <div class="container">
                <form method="post" id="newCourse" action="newEvent.php">
                    <div class="group">
                        <input name="cid" type="text" required="" autocomplete="off">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label id="newer">课程代码(6位)</label>
                    </div>
                    <div class="group">
                        <input name="cname" type="text" required="" autocomplete="off">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label id="newer">课程名</label>
                    </div>
                    <div class="group">
                        <input name="credit" type="text" required="" autocomplete="off">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label id="newer">学分</label>
                    </div>
                    <div class="group">
                        <input name="day" type="text" required="" autocomplete="off">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label id="newer">课程日期</label>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <sidebar>
        <div class="logo">教师端</div>
        <div class="avatar">
            <div class="avatar__img">
                <a href="teacherAbout.php"><img src="../static/images/headTEC.png" alt="个人信息"></a>
            </div>
            <div class="avatar__name">
                <?php echo $user_name; ?>
            </div>
        </div>
        <nav class="menu">
            <a class="menu__item" href="teacherIndex.php">
                <span class="menu__text">已开课程</span>
            </a>
            <a class="menu__item menu__item--active" href="#">
                <span class="menu__text">新开课程</span>
            </a>
            <a class="menu__item" href="teacherManage.php">
                <span class="menu__text">管理课程</span>
            </a>
            <a class="menu__item" href="teacherAbout.php">
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