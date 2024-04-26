<?php

require_once("conn.php");
session_start();

// Get user ID from session
$user_id = $_SESSION['userid'];

// Fetch the user's result in exam
$sql_fetch_result = "SELECT * FROM result WHERE user_id = '$user_id' ORDER BY exam_id DESC LIMIT 1";
$result_fetch_result = $conn->query($sql_fetch_result);

if ($result_fetch_result->num_rows > 0) {
    // Display users result
    $row = $result_fetch_result->fetch_assoc();
    echo "Your result for the latest exam:<br>";
    echo "Total Marks: " . $row['total_marks'];
} else {
    echo "No result found for the latest exam.";
}
$conn->close();
