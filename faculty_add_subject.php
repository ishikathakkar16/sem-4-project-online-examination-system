<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>
<?php
$addsubject = "";
$addsubjectErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["addsub"])) {
        $addsubjectErr = "Add subject first..";
    } else {
        $addsubject = input_data($_POST["addsub"]);
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
$usercourse = $_SESSION['usercourseupload'];

$query = "SELECT * FROM course";
$result1 = mysqli_query($conn, $query);
while ($pow = mysqli_fetch_assoc($result1)) {
    if ($pow['course_name'] == $usercourse) {
        $course_id = $pow['course_id'];
    }
}

if (isset($_POST['submit'])) {
    if (empty($addsubjectErr)) {
        $query = "INSERT INTO subject(subject_name, course_id) VALUES ('$addsubject', '$course_id')";
        mysqli_query($conn, $query);

        echo "<script type='text/javascript'>
            alert('Subject Added Successfully.');
            window.location = 'faculty_subject.php';
        </script>";
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label>Add Subject Name:</label>
    <input type="text" name="addsub" value="<?php echo $addsubject; ?>">
    <span class="error"><?php echo $addsubjectErr; ?></span><br><br>
    <button type="submit" name="submit">Add</button>
</form>

</body>
</html>
