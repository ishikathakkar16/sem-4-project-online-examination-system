<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.signup-container {
    max-width: 400px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #007bff;
    text-align: center;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"],
input[type="password"],
input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="checkbox"] {
    margin-right: 5px;
}

.error {
    color: #ff0000;
    font-size: 14px;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

@media (max-width: 500px) {
    .signup-container {
        width: 90%;
    }
}

    </style>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>  
.error {color: #FF0001;}  
</style>
</head>
<body>
    <?php
          require_once("conn.php");
          $query="SELECT * FROM user";
          $result=mysqli_query($conn,$query);

        $nameErr = $emailErr = $mobilenoErr = $agreeErr = $usernameErr = $passwordErr = $passkeyErr = $passkeyvalueErr = "";  
        $name = $email = $mobileno = $agree = $username = $password = $passkey = $passkeyvalue = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if ($name=empty($_POST["name"])) {  
                $nameErr = "Name is required";  
           } else {  
               $name = input_data($_POST["name"]);  
                   // check if name only contains letters and whitespace  
                   if (!preg_match("/^[a-zA-Z ]*$/",$name)) {  
                       $nameErr = "Only alphabets and white space are allowed";  
                   }  
           }  
             
           //Email Validation   
           if (empty($email=$_POST["email"])) {  
                   $emailErr = "Email is required";  
           } else {  
                   $email = input_data($_POST["email"]);  
                   // check that the e-mail address is well-formed  
                   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                       $emailErr = "Invalid email format";  
                   }  
            }  
           
           //Number Validation  
           if (empty($mobileno=$_POST["mobileno"])) {  
                   $mobilenoErr = "Mobile no is required";  
           } else {  
                   $mobileno = input_data($_POST["mobileno"]);  
                   // check if mobile no is well-formed  
                   if (!preg_match ("/^[0-9]*$/", $mobileno) ) {  
                   $mobilenoErr = "Only numeric value is allowed.";  
                   }  
               //check mobile no length should not be less and greator than 10  
               if (strlen ($mobileno) != 10) {  
                   $mobilenoErr = "Mobile no must contain 10 digits.";  
                   }  
           }  
             
            //username Validation  
            if (empty($username=$_POST["username"])) {  
                $usernameErr = "Username is required";  
            } 
            //check mobile no length should not be less and greator than 10  
            while($record=mysqli_fetch_assoc($result))
            {if (strcmp($record['username'],$username)==0) {  
                $usernameErr = "User already exists..";  
                }
            }  
        
            //Password Validation  
           if (empty($password=$_POST["password"])) {  
            $passwordErr = "Password is required";  
            } else {  
            $password = input_data($_POST["password"]);  
            // check if password is well-formed  
            if (!preg_match ("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{4,20}$/", $password) ) {  
            $passwordErr = "Match the following condition please!!";  
            }  
             
    }  
         
           //Checkbox Validation  
           if (!isset($_POST['agree'])){  
                   $agreeErr = "Accept terms of services before submit.";  
           } else {  
                   $agree = input_data($_POST["agree"]);  
           }


           if (!isset($_POST['passkey'])){  
            $passkeyErr = "Select Passkey Option..";  
            } else {  
            $passkey = input_data($_POST["passkey"]);  
            }


            if (empty($_POST['passkeyvalue'])){  
                $passkeyvalueErr = "Please fill passkey value..";  
                } else {  
                $passkeyvalue = input_data($_POST["passkeyvalue"]);  
                }

        }
    

    function input_data($data) {  
        $data = trim($data);  
        $data = stripslashes($data);  
        $data = htmlspecialchars($data);  
        return $data;  
      }  
    ?>

    <h2 style="color:blue;">Sign Up</h2>
    <span class="error">* Required fields...</span><br><br>

    <form method="post" name="signup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo $name; ?>" />
    <span class="error">* <?php echo $nameErr; ?> </span> <br><br>

    <label>Mobile No.</label>
    <input type="text" name="mobileno" value="<?php echo $mobileno; ?>" />
    <span class="error">* <?php echo $mobilenoErr; ?> </span> <br><br>

    <label>Email id.</label>
    <input type="text" name="email" value="<?php echo $email; ?>" />
    <span class="error">* <?php echo $emailErr; ?> </span> <br><br>

    <label>Username:</label>
    <input type="text" name="username" value="<?php echo $username; ?>" />
    <span class="error">* <?php echo $usernameErr; ?> </span> <br><br>

    <label>Password</label>
    <input type="password" name="password" value="<?php echo $password; ?>" />
    <span class="error">* <?php echo $passwordErr; ?> </span><br>
    <span class="error">(One Uppercase & lowercase & number & Uniquevalue(@#$%^&*-) is required..) </span><br><br>
    
    <label>PassKey if you forget the Password</label>
    <span class="error">* <?php echo $passkeyErr; ?> </span><br>
    <input type="radio" name="passkey" <?php if (isset($passkey) && $passkey=="favteacher") echo "checked"; ?> value="favteacher" />Fav Teacher<br>
    <input type="radio" name="passkey" <?php if (isset($passkey) && $passkey=="favmovie") echo "checked"; ?> value="favmovie" />Fav Movie<br>
    <input type="radio" name="passkey" <?php if (isset($passkey) && $passkey=="fathersname") echo "checked"; ?> value="fathersname" />Father's Name<br><br>

    <label>PassKey Value</label>
    <input type="text" name="passkeyvalue" value="<?php echo $passkeyvalue; ?>" />
    <span class="error">* <?php echo $passkeyvalueErr; ?> </span><br><br>

    <input type="checkbox" name="agree">
    Agree to Terms of Service:  
    <span class="error">* <?php echo $agreeErr; ?> </span> <br><br>

    <input type="submit" name="submit">
    </form>  

<?php
    require_once("conn.php");
    
    if(isset($_POST['submit']))
        {
            if($nameErr == "" && $emailErr == "" && $mobilenoErr == "" && $usernameErr == "" && $passwordErr == ""  && $agreeErr == "" && $passkeyErr == "" && $passkeyvalueErr == "" )
            {
            $query="INSERT INTO user(name,mobileno,email,username,password,passkey,passkeyval)
            values('$name','$mobileno','$email','$username','$password','$passkey','$passkeyvalue')";
            mysqli_query($conn,$query);
            header("location:redirect.php");
            }
        }
    ?>
</body>
</html>
</body>
</html>