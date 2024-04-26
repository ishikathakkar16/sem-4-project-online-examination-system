<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
    <style>  
        .error {color: #FF0000;}  
    </style>
</head>
<body>
<?php
session_start();
require_once("conn.php");  

$usernameErr = $passwordErr = $captchaErr = "";  
$username = $password = "";

function input_data($data) {  
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = input_data($_POST["username"]);
    $password = input_data($_POST["password"]);
    $captcha_input = input_data($_POST["captcha"]);

    $usernameErr = empty($username) ? "Username is required" : '';
    $passwordErr = empty($password) ? "Password is required" : '';
    $captchaErr = empty($captcha_input) ? "Captcha is required" : '';

    if (!empty($captcha_input) && $captcha_input != $_SESSION['captcha_code']) {
        $captchaErr = "Captcha mismatched, please try again";
    }

    if (empty($usernameErr) && empty($passwordErr) && empty($captchaErr)) {
        $username = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM user WHERE BINARY username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['userid'] = $row['user_id'];
                $_SESSION['username'] = $row['name'];
                $_SESSION['usercategory'] = $row['user_category'];
                $_SESSION['status'] = $row['status'];
                if ($row['status'] == 'approved') {
                    header("Location: " . $row['user_category'] . "_interface.php");
                    exit();
                } else {
                    echo '<script>alert("Your account is pending approval.");</script>';
                }
            } else {
                $passwordErr = "Incorrect password";
            }
        } else {
            $usernameErr = "Username not found";
        }
    }
}

$captcha_code = substr(md5(mt_rand()), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;
?>
<div class="container">
    <h1>Login</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Enter your username"/>
        <span class="error"><?php echo $usernameErr; ?></span><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Enter your password"/>
        <span class="error"><?php echo $passwordErr; ?></span><br><br>
        
        <label for="captcha">Enter Captcha:</label>
        <input type="text" id="captcha" name="captcha">
        <span class="error"><?php echo $captchaErr; ?></span><br><br>
        <img src="data:image/jpeg;base64,<?php echo base64_encode(generateCaptcha()); ?>" alt="Captcha Image"><br><br>
        
        <button type="submit" name="submit">Sign in</button>
    </form> 
    <br>
    <span class="psw">Forgot <a href="forgetpassword.php">password?</a></span>
    Are you new? <a href="signup.php">Create an Account</a>
</div>

<?php
function generateCaptcha() {
    $image = imagecreate(100, 30);
    $background_color = imagecolorallocate($image, 255, 255, 255);
    $text_color = imagecolorallocate($image, 0, 0, 0);
    $captcha_code = $_SESSION['captcha_code'];
    imagestring($image, 5, 10, 8, $captcha_code, $text_color);
    ob_start();
    imagejpeg($image);
    $image_data = ob_get_clean();
    imagedestroy($image);
    return $image_data;
}
?>
</body>
</html>
