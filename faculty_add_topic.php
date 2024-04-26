<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Topic</title>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>
<?php
$addtopic = "";
$addtopicErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["addtopic"])) {
        $addtopicErr = "Add Topic first..";
    } else {
        $addtopic = input_data($_POST["addtopic"]);
    }
}

function input_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Database connection
require_once("conn.php");
session_start();
$usersubject=$_SESSION['usersubjectupload'];

$query="SELECT * from subject";
$result1=mysqli_query($conn,$query);
while($pow=mysqli_fetch_assoc($result1))
{
    if($pow['subject_name']==$usersubject){
    $subject_id=$pow['subject_id'];}
}

if (isset($_POST['submit'])) {
    if (empty($addtopicErr)) {
        $query1 = "INSERT INTO topic(topic_name, subject_id) VALUES ('$addtopic', '$subject_id')";
        mysqli_query($conn, $query1);

        echo "<script type='text/javascript'>
            alert('Topic Added Successfully.');
            window.location = 'faculty_topic.php';
        </script>";
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label>Add Topic Name:</label>
    <input type="text" name="addtopic" value="<?php echo $addtopic; ?>">
    <span class="error"><?php echo $addtopicErr; ?></span><br><br>
    <button type="submit" name="submit">Add</button>
</form>

</body>
</html>
