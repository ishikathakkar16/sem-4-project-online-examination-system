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

<?php
$usersubject="";
$usersubjectErr="";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
if (empty($usersubject=$_POST["user_subject"])){  
    $usersubjectErr = "Select in which subject you want to upload CSV file..";  
    } else {  
    $usersubject = input_data($_POST["user_subject"]);  
    }       
}
    function input_data($data) {  
        $data = trim($data);  
        $data = stripslashes($data);  
        $data = htmlspecialchars($data);  
        return $data;  
      } 
?>

<?php
require_once("conn.php");
session_start();
$usercourse=$_SESSION['usercourseupload'];

$query="SELECT * from course";
$result1=mysqli_query($conn,$query);
while($pow=mysqli_fetch_assoc($result1))
{
    if($pow['course_name']==$usercourse){
    $course_id=$pow['course_id'];}
}
$query1="SELECT * from subject where course_id=".$course_id;
$result=mysqli_query($conn,$query1);

?>
<body>
<form method="post">
    <label>Please Select Subject<br><br>
        <select name="user_subject" id="subject">
            <?php

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                echo "<option value=''>Select Subject</option>";
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row["subject_name"] . "'>" . $row["subject_name"] . "</option>";
                }
            } else {
                echo "<option>No products found</option>";
            }
            ?>
        </select>
        <span class="error"><?php echo $usersubjectErr; ?> </span><br><br>
        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
if(isset($_POST['submit']))
        {
            if(empty($usersubjectErr))
            {
                $_SESSION['usersubjectupload']=$usersubject;
                header("location:faculty_topic.php");
            }
        }
?>

<br><br>
<a href="faculty_add_subject.php">Want to Add More Subject???</a>

</body>
</html>