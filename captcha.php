<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    echo $_SESSION['captcha_code'];
    echo $_POST['captcha'];
    if ($_POST['captcha'] == $_SESSION['captcha_code']) {
            echo "Captcha verification passed!"; 
    } else {  
        echo "Captcha verification failed!";
    }
}
else{
$captcha_code = substr(md5(mt_rand()), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;
}
?>

<html>
<head>
    <title>PHP Captcha Example</title>
</head>
<body>
    <h2>Enter the Captcha</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="captcha">Enter Captcha:</label><br>
        <input type="text" id="captcha" name="captcha"><br><br>
        <img src="data:image/jpeg;base64,<?php echo base64_encode(generateCaptcha()); ?>" alt="Captcha Image"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

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
