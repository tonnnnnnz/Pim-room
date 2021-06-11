<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image" sizes="16x16" href="images/Logo_PIM.png" />
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <div class="text-center">      
                <img src="images/Logo_PIM.png" alt="PIM Logo" width="150" height="150">
            </div>
            &nbsp;
            <form class="login-form" method="post" action="member/check_login.php">
                <input type="text" placeholder="Enter Username" name="username" value="<?php if(isset($_COOKIE["userlogin"])) { echo $_COOKIE["userlogin"]; } ?>" require>
                <input type="password" placeholder="Enter password" name="password" value="<?php if(isset($_COOKIE["passwordform"])) { echo $_COOKIE["passwordform"]; } ?>" require>
                <button type="submit">login</button>
            </form>
        </div>
    </div>
</body>
</html>