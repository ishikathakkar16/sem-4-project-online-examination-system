<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <style>  
.error {color: #FF0001;}  
</style>
</head>
<body>
<?php
require_once("conn.php");

$usernameErr = $passkeyErr = $passkeyvalueErr = "";  
$username = $passkeyvalue = $passkey = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = input_data($_POST["username"]); 
    }

    if (empty($passkey=$_POST["passkey"])){  
        $passkeyErr = "Select Passkey Option..";  
        } else {  
        $passkey = input_data($_POST["passkey"]);  
        }


        if (empty($_POST['passkeyvalue'])){  
            $passkeyvalueErr = "Please fill passkey value..";  
            } else {  
            $passkeyvalue = input_data($_POST["passkeyvalue"]);  
            }

    if ($usernameErr == "" && $passkeyErr == "" && $passkeyvalueErr == "") {
        $query = "SELECT * FROM user WHERE BINARY username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if($row['passkey'] == $passkey)
            {
            if ($row['passkeyval'] == $passkeyvalue) {
                header("Location: resetpassword.php?username=" .$username);
                exit();
            } else {
                $passkeyvalueErr = "Passkey Value is incorrect";
            }
        }
        else
        {
            $passkeyErr = "Passkey is incorrect";   
        }
        } else {
            $usernameErr = "Username not found";
        }
    }
}

function input_data($data) {  
    $data = trim($data);  
    $data = stripslashes($data);  
    $data = htmlspecialchars($data);  
    return $data;  
}
?>
    <div class="container">
    <h1>Forget Password?</h1>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label>Username:</label>
    <input type="text" name="username" value="<?php echo $username; ?>"/>
    <span class="error"> <?php echo $usernameErr; ?> </span><br><br>

    <label for="passkey">PassKey Label</label><br><br>
        <select name="passkey" id="passkey" placeholder="Choose a passkey">
            <option value="">--- Choose a passkey ---</option>
            <option <?php if (isset($passkey) && $passkey=="favteacher") echo "selected"; ?> value="favteacher">Fav Teacher</option>
            <option <?php if (isset($passkey) && $passkey=="favmovie") echo "selected"; ?> value="favmovie">Fav Movie</option>
            <option <?php if (isset($passkey) && $passkey=="favbook") echo "selected"; ?> value="favbook">Fav Book</option>
        </select><br><br>
        <span class="error"><?php echo $passkeyErr; ?> </span><br><br>

    <label>PassKey Value</label>
    <input type="text" name="passkeyvalue" value="<?php echo $passkeyvalue; ?>" />
    <span class="error"> <?php echo $passkeyvalueErr; ?> </span><br><br>

    <button type="submit" name="submit">NEXT</button>
    </form>  
    <br>
</div>
</body>
</html>