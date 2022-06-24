<body>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title>密码重置</title>
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
    <h2><?php echo "密码重置"; ?></h2>
    <form class="form-box" method="post" action="resetEvent.php">
        <div class="inputBox">
            <input type="text" name="uid" autocomplete="off" required="">
            <label>用户名</label>
        </div>
        <div class="inputBox">
            <input type="text" name="phone" autocomplete="off" required="">
            <label>手机号</label>
        </div>
        <div class="inputBox">
            <input type="text" name="atcode" autocomplete="off" required="">
            <label>验证码(0000)</label>
        </div>
        <div class="inputBox">
            <input type="password" name="pwd_new1" autocomplete="off" required="">
            <label>新密码</label>
        </div>
        <div class="inputBox">
            <input type="password" name="pwd_new2" autocomplete="off" required="">
            <label>确认密码</label>
        </div>
        <input type="submit" value="确认">
    </form>
</div>
</body>
<footer><p class="footer" style="color: #FFFFFF">&copy;2022 Made by <a href="https://www.yolel.cn"
                                                                       target="_blank">Yolel</a></p></footer>
</html>

</body>