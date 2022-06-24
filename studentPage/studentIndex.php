<head>
    <title>学生端</title>
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
        case "tname":
            return "授课教师";
        case "tcollege":
            return "开课学院";
        case "credit":
            return "学分";
        case "score":
            return "成绩";
        default:
            return "";
    }
}

function putRow($row): void
{
    echo '<tr>';
    foreach ($row as $key => $value) {
        if ($value != null)
            echo '<td class="text-left">' . $value . '</td>';
        else
            echo '<td class="text-left">' . "尚未出成绩" . '</td>';
    }
    echo '</tr>';
}

function putHead($row): void
{
    $keys = array_keys($row);
    echo '<tr>';
    foreach ($keys as $key => $value) {
        echo '<th class="text-left">' . mapped($value) . '</th>';
    }
    echo '</tr>';
}

function putTable($rec)
{
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
        echo "选课记录为空！请检查是否已经选课。";
    }
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

$rec = $connect->query("SELECT `sname` FROM `student` WHERE `sid` = '{$uid}'");
$row = $rec->fetch_array(MYSQLI_ASSOC);

$user_name = $row['sname'];

?>
<div class="wrapper">
    <main>
        <div class="toolbar">
            <div class="current-month" style="font-weight: normal;font-size: 20px">
                已选课程
            </div>
        </div>
        <div class="calendar">
            <?php
            $qy = <<<QUERY
                SELECT course.cid, cname, tname, credit, score 
                FROM course, chosedcourse, teacher 
                WHERE course.cid = chosedcourse.cid 
                AND course.tid = teacher.tid 
                AND chosedcourse.sid = '{$uid}';
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
            <a class="menu__item menu__item--active" href="#">
                <span class="menu__text">已选课程</span>
            </a>
            <a class="menu__item" href="studentChoose.php">
                <span class="menu__text">选择课程</span>
            </a>
            <a class="menu__item" href="studentCancel.php">
                <span class="menu__text">撤销选课</span>
            </a>
            <a class="menu__item" href="studentAbout.php">
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
    </a>
</div>
</body>