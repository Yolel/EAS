<html lang="zh">
<head>
    <meta charset="utf-8">
    <title>用户注册</title>
    <link href="static/css/register.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="./static/images/favicon.ico">
</head>

<body>
<a class="back-left" href="./index.php">
    <svg viewBox="0 0 24 24">
        <path d="M9 13L5 9l4-4M5 9h11a4 4 0 0 1 0 8h-1" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
</a>
<div class="box">
    <h2><?php echo "注册帐号"; ?></h2>
    <form class="form-box" method="post" action="registerEvent.php">
        <div class="inputBox">
            <input type="text" name="uid" autocomplete="off" required="">
            <label>用户名（12位学号或10位教职工号）</label>
        </div>
        <div class="inputBox">
            <input type="password" name="pwd" autocomplete="off" required="">
            <label>密码</label>
        </div>
        <b>个人信息：</b><br><br>
        <div class="inputBox">
            <input type="text" name="name" autocomplete="off" required="">
            <label>姓名</label>
        </div>
        <label>性别:&emsp;&emsp;
            <input type="radio" name="sex" value="male" id="" class="a-radio">
            <span class="b-radio"></span>男
        </label>
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <label>
            <input type="radio" name="sex" value="female" id="" class="a-radio">
            <span class="b-radio"></span>女
        </label>
        <br><br>
        <div class="inputBox">
            <input type="text" name="college" autocomplete="off" required="">
            <label>院系</label>
        </div>
        <input type="submit" value="确认">
    </form>
</div>
</body>
<footer><p class="footer" style="color: #FFFFFF">&copy;2022 Made by <a href="https://www.yolel.cn"
                                                                       target="_blank">Yolel</a></p></footer>
</html>
