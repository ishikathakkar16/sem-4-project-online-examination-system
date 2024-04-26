<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Upload</title>
</head>

<body>
    <?php
    session_start();
    require_once("conn.php");

    if (!isset($_SESSION['usertopicupload'])) {
        echo "<script>alert('No topic selected.'); window.location = 'selectTopic.php';</script>";
        exit;
    }

    $topicname = mysqli_real_escape_string($conn, $_SESSION['usertopicupload']);
    $query = "SELECT topic_id FROM topic WHERE topic_name = '$topicname'";
    $result = mysqli_query($conn, $query);
    $topicid = null;

    if ($row = mysqli_fetch_assoc($result)) {
        $topicid = $row['topic_id'];
    } else {
        echo "<script>alert('Topic not found.'); window.location = 'selectTopic.php';</script>";
        exit;
    }

    if (isset($_POST["submit"])) {
        if (isset($_FILES["file"]["tmp_name"]) && is_uploaded_file($_FILES["file"]["tmp_name"])) {
            $filename = $_FILES["file"]["tmp_name"];
            $targetDir = "uploads/";
            $safeFilename = mysqli_real_escape_string($conn, basename($_FILES["file"]["name"]));
            $targetFile = $targetDir . $safeFilename;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if ($imageFileType != "csv") {
                echo "<script>alert('Invalid file type: Please upload a CSV file.'); window.location = 'csvupload.php';</script>";
                exit();
            }

            if (move_uploaded_file($filename, $targetFile)) {
                $file = fopen($targetFile, "r");

                if ($file !== false) {
                    while (($getData = fgetcsv($file, 1000, ",")) !== FALSE) {
                        if (count($getData) != 8 || in_array("", $getData, true)) {
                            echo "<script>alert('CSV file format is incorrect. Each row should contain 8 columns and no blank cells.'); window.location = 'csvupload.php';</script>";
                            fclose($file);
                            exit();
                        }

                        $question = mysqli_real_escape_string($conn, $getData[0]);
                        $option1 = mysqli_real_escape_string($conn, $getData[1]);
                        $option2 = mysqli_real_escape_string($conn, $getData[2]);
                        $option3 = mysqli_real_escape_string($conn, $getData[3]);
                        $option4 = mysqli_real_escape_string($conn, $getData[4]);
                        $correct_answer = mysqli_real_escape_string($conn, $getData[5]);
                        $question_category = mysqli_real_escape_string($conn, $getData[6]);
                        $difficulty_level = mysqli_real_escape_string($conn, $getData[7]);

                        $sql = "INSERT INTO mcq (topic_id, question, option1, option2, option3, option4, correct_answer, question_category, difficulty_level) VALUES ('$topicid', '$question', '$option1', '$option2', '$option3', '$option4', '$correct_answer', '$question_category', '$difficulty_level')";
                        if (!mysqli_query($conn, $sql)) {
                            echo "<script>alert('Error: SQL error occurred.'); window.location = 'csvupload.php';</script>";
                            fclose($file);
                            exit();
                        }
                    }

                    fclose($file);
                    echo "<script>alert('CSV File has been successfully imported.'); window.location = 'faculty_interface.php';</script>";
                } else {
                    echo "<script>alert('Error: Unable to open uploaded file.'); window.location = 'csvupload.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Error: Problem uploading file. Please try again.'); window.location = 'csvupload.php';</script>";
            }
        }
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <p>Select CSV file to upload:</p>
        <input type="file" name="file" id="file"><br><br>
        <input type="submit" value="Upload CSV" name="submit">
    </form>

</body>

</html>