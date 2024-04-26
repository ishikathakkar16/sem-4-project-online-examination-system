<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="signup.css">
    <style>  
.error {color: #FF0001;}  
</style>
</head>
<body>
    <?php
          require_once("conn.php");
          $query="SELECT * FROM user";
          $result=mysqli_query($conn,$query);

        $nameErr = $emailErr = $mobilenoErr = $agreeErr = $usercategoryErr = $usercourseErr = $usernameErr = $passwordErr = $passkeyErr = $passkeyvalueErr = "";  
        $name = $email = $mobileno = $agree = $usercategory = $usercourse = $username = $password = $passkey = $passkeyvalue = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (empty($_POST["name"])) {  
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


           if (empty($passkey=$_POST["passkey"])){  
            $passkeyErr = "Select Passkey Option..";  
            } else {  
            $passkey = input_data($_POST["passkey"]);  
            }

            if (empty($usercategory=$_POST["user_category"])){  
                $usercategoryErr = "Select user category Option..";  
                } else {  
                $usercategory = input_data($_POST["user_category"]);  
                }

                if (empty($usercourse=$_POST["user_course"])){  
                    $usercourseErr = "Select user course Option..";  
                    } else {  
                    $usercourse = input_data($_POST["user_course"]);  
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

<div class="container">
    <h1>Sign Up</h1>
    <!--<span class="error">* Required fields...</span><br><br>-->

    <form method="post" name="signup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>" placeholder="Enter your name"/>
        <span class="error">* <?php echo $nameErr; ?> </span> <br><br>

        <label for="mobileno">Mobile No.</label>
        <input type="text" name="mobileno" id="mobileno" value="<?php echo $mobileno; ?>" placeholder="Enter your mobile number"/>
        <span class="error">* <?php echo $mobilenoErr; ?> </span> <br><br>

        <label for="email">Email id.</label>
        <input type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter your email address"/>
        <span class="error">* <?php echo $emailErr; ?> </span> <br><br>

        <label for="user_category">Choose Category</label><br><br>
        <select name="user_category" id="user_category" placeholder="Choose a category">
            <option value="">--- Choose a Category ---</option>
            <option <?php if (isset($usercategory) && $usercategory=="faculty") echo "selected"; ?> value="faculty">Faculty</option>
            <option <?php if (isset($usercategory) && $usercategory=="student") echo "selected"; ?> value="student">Student</option>
        </select>  <br>
        <span class="error">* <?php echo $usercategoryErr; ?> </span><br><br>

        <label for="user_course">Choose Course</label><br><br>
        <select name="user_course" id="user_course" placeholder="Choose a Course">
            <option value="">--- Choose a Course ---</option>
            <option <?php if (isset($usercourse) && $usercourse=="msccs") echo "selected"; ?> value="msccs">MSCCS</option>
            <option <?php if (isset($usercourse) && $usercourse=="aiml") echo "selected"; ?> value="aiml">AIML</option>
            <option <?php if (isset($usercourse) && $usercourse=="mca") echo "selected"; ?> value="mca">MCA</option>
        </select>  <br>
        <span class="error">* <?php echo $usercourseErr; ?> </span><br><br>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo $username; ?>" placeholder="Enter your username"/>
        <span class="error">* <?php echo $usernameErr; ?> </span> <br><br>

        <label for="password">Password</label><br>
        <span class="error">(One Uppercase & lowercase & number & Uniquevalue(@#$%^&*-) is required..) </span><br>
        <input type="password" name="password" id="password" value="<?php echo $password; ?>" placeholder="Enter your password"/>
        <span class="error">* <?php echo $passwordErr; ?> </span><br><br>
        
        <label for="passkey">PassKey if you forget the Password</label><br><br>
        <select name="passkey" id="passkey" placeholder="Choose a passkey">
            <option value="">--- Choose a passkey ---</option>
            <option <?php if (isset($passkey) && $passkey=="favteacher") echo "selected"; ?> value="favteacher">Fav Teacher</option>
            <option <?php if (isset($passkey) && $passkey=="favmovie") echo "selected"; ?> value="favmovie">Fav Movie</option>
            <option <?php if (isset($passkey) && $passkey=="favbook") echo "selected"; ?> value="favbook">Fav Book</option>
        </select><br>
        <span class="error">* <?php echo $passkeyErr; ?> </span><br><br>

        <label for="passkeyvalue">PassKey Value</label>
        <input type="text" name="passkeyvalue" id="passkeyvalue" value="<?php echo $passkeyvalue; ?>" placeholder="Enter your passkey value"/>
        <span class="error">* <?php echo $passkeyvalueErr; ?> </span><br><br>

        <input type="checkbox" name="agree">
        Agree to Terms of Service:  <br><br>
        <span class="error">* <?php echo $agreeErr; ?> </span> <br><br>

        <button type="submit" name="submit">Sign in</button>
    </form>
</div>
 

<?php
    require_once("conn.php");
    $hash=password_hash($password,PASSWORD_DEFAULT);
    if(isset($_POST['submit']))
        {
            if($nameErr == "" && $emailErr == "" && $usercategoryErr == "" && $usercourseErr == ""  && $mobilenoErr == "" && $usernameErr == "" && $passwordErr == ""  && $agreeErr == "" && $passkeyErr == "" && $passkeyvalueErr == "" )
            {
                $course="select * from course";
                $result=mysqli_query($conn,$course);

                while($rec=mysqli_fetch_assoc($result))
                {
                    if($rec['course_name']==$usercourse)
                    {
                        $course_id=$rec['course_id'];
                    }
                }

            $query="INSERT INTO user(name,mobileno,email,username,password,passkey,passkeyval,user_category,course_id,status)
            values('$name','$mobileno','$email','$username','$hash','$passkey','$passkeyvalue','$usercategory','$course_id','pending')";
            mysqli_query($conn,$query);
            header("location:redirect.php");
            }
    }
    ?>
</body>
</html>