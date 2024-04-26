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
session_start();

echo "Hello ".$_SESSION['username'];
echo "<br>";

$usercourse="";
$usercourseErr="";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
if (empty($usercourse=$_POST["user_course"])){  
    $usercourseErr = "Select in which course you want to upload CSV file..";  
    } else {  
    $usercourse = input_data($_POST["user_course"]);  
    }
}
    function input_data($data) {  
        $data = trim($data);  
        $data = stripslashes($data);  
        $data = htmlspecialchars($data);  
        return $data;  
      } 
?>
<br>
<form method="post">
Please Enter Course in which you want to upload a CSV file...<br><br>
        <select name="user_course" id="user_course" placeholder="Choose a Course">
            <option value="">--- Choose a Course ---</option>
            <option <?php if (isset($usercourse) && $usercourse=="msccs") echo "selected"; ?> value="msccs">MSCCS</option>
            <option <?php if (isset($usercourse) && $usercourse=="aiml") echo "selected"; ?> value="aiml">AIML</option>
            <option <?php if (isset($usercourse) && $usercourse=="mca") echo "selected"; ?> value="mca">MCA</option>
        </select>  <br>
        <span class="error"><?php echo $usercourseErr; ?> </span><br>

        <button type="submit" name="submit">Go</button>
</form>

<?php
if(isset($_POST['submit']))
        {
            if($usercourseErr == "")
            {
                $_SESSION['usercourseupload']=$usercourse;
                header("location:faculty_subject.php");
            }
        }
?>

</body>
</html>