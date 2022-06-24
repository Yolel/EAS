<head>
    <title>学生端</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../static/css/user.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../static/images/favicon.ico">
</head>

<body>
<script>
    function lets_click() {
        let input = document.getElementsByTagName("input");
        for (let i = 0; i < input.length; i++) {
            if (input[i].type === "checkbox") {
                input[i].checked = input[i].checked !== true;
            }
        }
    }
</script>
<?php
function mapped($value): string
{
    return match ($value) {
        "cid" => "课程代码",
        "cname" => "课程名",
        "tname" => "授课教师",
        "tcollege" => "开课学院",
        "credit" => "学分",
        "score" => "成绩",
        "day" => "日期",
        default => "",
    };
}

function putRow($row)
{
    echo '<tr>';
    foreach ($row as $key => $value) {
        echo '<td class="text-left">' . $value . '</td>';
    }
    echo '<td class="text-center">';
    echo "<input type='checkbox' name='chosen[]' value='{$row['cid']}'>";
    echo '</td>';
    echo '</tr>';
}

function putHead($row)
{
    $keys = array_keys($row);
    echo '<tr>';
    $flag = 0;
    foreach ($keys as $key => $value) {
        echo '<th class="text-left">' . mapped($value) . '</th>';

    }
    echo '<th class="text-center">选课</th>';
    echo '</tr>';
}

function putTable($rec)
{
    echo '<form method="post" action="choseEvent.php" id="chosenCourses">';
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
        echo "已无未选的课程。";
    }
    echo '</form>';
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
            <div class="current-month" style="font-weight: normal;font-size: 20px">
                选择课程
            </div>
            <div class="search bar" style="position: absolute;right: 210px">
                <form class="form1" method="post" action="fuzzsearch.php">
                    <input class="input1" type="text" name="fuzz" placeholder="请输入您要搜索的课程名">
                    <button class="button1" type="submit"></button>
                </form>
            </div>
            <div class="toggle">
                <div class="toggle__option" onclick="lets_click()">反选</div>
                <div class="toggle__option" onclick="document.getElementById('chosenCourses').submit()">提交</div>
            </div>

        </div>
        <div class="calendar">
            <?php
            $fu = $_POST['fuzz'];
            $qy = <<<QUERY
                SELECT cid, cname, tname, tcollege, credit,day
                FROM course, teacher
                WHERE NOT EXISTS(
                    SELECT * FROM chosedcourse
                    WHERE sid = '{$uid}'
                    AND course.cid = chosedcourse.cid
                ) AND teacher.tid = course.tid AND course.cname like '%{$fu}%';
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
            <a class="menu__item menu__item--active" href="#">
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
</div>
</body>