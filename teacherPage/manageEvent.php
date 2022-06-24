<head>
    <title>教师端</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../static/css/user.css" rel="stylesheet" type="text/css">
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
        case "sname":
            return "学生姓名";
        case "scollege":
            return "院系";
        case "sid":
            return "学号";
        case "credit":
            return "学分";
        case "score":
            return "成绩";
        default:
            return "";
    }
}

function putRow($row)
{
    echo '<tr>';
    foreach ($row as $key => $value) {
        if ($key == 'score') {
            break;
        }
        echo "<td class='text-left'>" . $value . "</td>";
    }
    echo "<td class='text-center'>";
    echo "<input type='hidden' name='sid[]' value='{$row['sid']}'>";
    echo "<input type='text' name='score[]' value='{$row['score']}' autocomplete='off'>";
    echo "</td>";
    echo '</tr>';
}

function putHead($row): void
{
    $keys = array_keys($row);
    echo '<tr>';
    foreach ($keys as $key => $value) {
        if ($value == 'score') {
            echo "<th class='text-center'>" . mapped($value) . "</th>";
        } else {
            echo "<th class='text-left'>" . mapped($value) . "</th>";
        }
    }
    echo '</tr>';
}

function putTable($man, $rec): void
{
    echo '<form method="post" action="manageEvent2.php" id="manageCourses">';
    echo "<input type='hidden' name='manage' value='{$man}'>";
    if ($row = $rec->fetch_array(MYSQLI_ASSOC)) {
        echo '<table class="table-fill">';
        echo '<thead>';
        putHead($row);
        echo '</thead>';
        echo '<tbody class="table-hover">';
        putRow($row);
        while ($row = $rec->fetch_array(MYSQLI_ASSOC)) {
            putRow($row);
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "暂无学生选这门课。";
    }
    echo '</form>';
    echo '<form method="post" action="deleteEvent.php" id="deleteCourses">';
    echo "<input type='hidden' name='manage' value='{$man}'>";
    echo '</form>';
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

if (!isset($_POST['manage'])) {
    header("location: teacherManage.php");
    return;
}
$manage = $_POST['manage'];

$rec = $connect->query("SELECT tname FROM teacher WHERE tid = '{$uid}'");
$row = $rec->fetch_array(MYSQLI_ASSOC);

$user_name = $row['tname'];

$rec = $connect->query("SELECT cname FROM course WHERE cid = '{$manage}'");
$row = $rec->fetch_array(MYSQLI_ASSOC);

$course_name = $row['cname'];

?>
<div class="wrapper">
    <main>
        <div class="toolbar">
            <div class="current-month" style="font-weight: normal;font-size: 20px">
                管理课程 - (<?php echo $manage ?>)<?php echo $course_name ?> - 选课名单
            </div>
            <div class="toggle">
                <div class="toggle__option" onclick="document.getElementById('deleteCourses').submit()">删除</div>
                <div class="toggle__option" onclick="document.getElementById('manageCourses').submit()">提交</div>
            </div>
        </div>
        <div class="calendar">
            <?php
            $qy = <<<QUERY
                SELECT student.sid, sname, scollege, score
                FROM student, chosedcourse
                WHERE chosedcourse.cid = '{$manage}'
                AND chosedcourse.sid = student.sid;
            QUERY;
            $rec = $connect->query($qy);
            putTable($manage, $rec);
            ?>
        </div>
    </main>
    <sidebar>
        <div class="logo">教师端</div>
        <div class="avatar">
            <div class="avatar__img">
                <a href="teacherAbout.php"><img src="../static/images/headTEC.png" alt="avatar"></a>
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
            <a class="menu__item menu__item--active" href="teacherManage.php">
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