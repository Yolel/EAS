<!doctype html>
<html lang="zh">
<head>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <title>济南大学教务系统</title>
    <link rel="shortcut icon" href="./static/images/favicon.ico">
    <script>try {
            let Typekit;
            Typekit.load({async: true});
        } catch (e) {
        }</script>

    <link href="static/css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
if (isset($_COOKIE['uid'])) {
    if (strlen($_COOKIE['uid']) == 12) {
        header("location: studentPage/studentIndex.php");
    } elseif (strlen($_COOKIE['uid']) == 10) {
        header("location: teacherPage/teacherIndex.php");
    }
}
?>

<header style="background: white;opacity: 0.7;">
    <a class="site-logo">
        <img src="static/images/logo.png" alt="">
        <span class="nav-font" style="font-size: 20px; vertical-align: middle">
                济南大学教务系统
        </span>
    </a>
    <nav class="site-nav-right">
        <a>弘毅博学 求真至善</a>
    </nav>
</header>

<main>
    <section class="yolel">
        <div>
            <img src="static/images/UJN.jpg" alt="">
            <div class="container">
                <div class="typed-out">勤奋、严谨</p></div>
                <div class="typed-out" style="margin-top: 40px;animation-delay: 1.6s">团结、创新</p></div>
            </div>
            <div class="inscribe">
                <div class="typed-out_i" style="animation-delay: 3.2s">——济南大学</div>
            </div>
        </div>

        <form class="box" action="login.php" method="post">
            <h2 style="font-size: 20px">登录</h2>
            <label>
                <input type="text" name="uid" placeholder="用户名" autocomplete="off" required="">
            </label>
            <label>
                <input type="password" name="pwd" placeholder="密码" autocomplete="off" required="">
            </label>
            <ul style="display: block;float: left">
                <li style="margin-left: 40px">
                    <label for="acode"></label><input id="acode" type="text" name="acode" placeholder="验证码"
                                                      autocomplete="off" required="">
                </li>
                <li style="display: block;height: 75px">
                    <div style="line-height: 75px;display: inline-block;margin-left: 20px">
                        <img src="./static/images/code.jpeg" alt="">
                    </div>
                </li>
            </ul>
            <ul class="menu">
                <li id="register">
                    还没有帐号？<a href="register.php">立即注册</a>
                </li>
                <li id="reset">
                    <a href="reset.php">忘记密码</a>
                </li>
            </ul>
            <input type="submit" value="确认">
        </form>
    </section>
</main>
<footer><p class="footer" style="color: #FFFFFF">&copy;2022 Made by <a href="https://www.yolel.cn"
                                                                       target="_blank">Yolel</a></p></footer>
</body>
</html>