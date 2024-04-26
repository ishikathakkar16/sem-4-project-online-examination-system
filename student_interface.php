<?php
require_once("conn.php");
session_start();

// Fetch courses from db
$sql = "SELECT * FROM course";
$result = $conn->query($sql);

// Fetch subjects from db
$sql_subjects = "SELECT * FROM subject";
$result_subjects = $conn->query($sql_subjects);

// Fetch topics from db
$sql_topics = "SELECT * FROM topic";
$result_topics = $conn->query($sql_topics);

$totalMarks = 0;

// no of questions
$expectedQuestionsCount = 10;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $selectedCourse = $_POST['course'];
    $selectedSubject = $_POST['subject'];
    $selectedTopic = $_POST['topic'];
    $selectedDifficulty = $_POST['difficulty'];

    // fetch questions not attempted yet
    $sql_questions = "SELECT mcq.* FROM mcq
                      LEFT JOIN exam_question ON mcq.mcq_id = exam_question.mcq_id
                      WHERE exam_question.mcq_id IS NULL
                      AND mcq.topic_id = '$selectedTopic' 
                      AND mcq.difficulty_level = '$selectedDifficulty'
                      ORDER BY RAND() LIMIT $expectedQuestionsCount";
    $result_questions = $conn->query($sql_questions);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Take MCQ Exam</title>
        <script>
            function validateForm() {
                var questions = document.querySelectorAll('input[type="radio"]');
                var answeredCount = 0;
                for (var i = 0; i < questions.length; i++) {
                    if (questions[i].checked) {
                        answeredCount++;
                    }
                }
                if (answeredCount < <?php echo $expectedQuestionsCount; ?>) {
                    alert("Please answer all questions before submitting.");
                    return false;
                }
                return true;
            }
        </script>
    </head>

    <body>
        <h1>MCQ Exam</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
            <?php
            // Displayin' questions
            while ($row = $result_questions->fetch_assoc()) {
                echo "<h3>" . $row['question'] . "</h3>";
                echo "<input type='radio' name='answers[" . $row['mcq_id'] . "]' value='" . $row['option1'] . "'>" . $row['option1'] . "<br>";
                echo "<input type='radio' name='answers[" . $row['mcq_id'] . "]' value='" . $row['option2'] . "'>" . $row['option2'] . "<br>";
                echo "<input type='radio' name='answers[" . $row['mcq_id'] . "]' value='" . $row['option3'] . "'>" . $row['option3'] . "<br>";
                echo "<input type='radio' name='answers[" . $row['mcq_id'] . "]' value='" . $row['option4'] . "'>" . $row['option4'] . "<br><br>";
            }
            ?>
            <input type="hidden" name="course" value="<?php echo $selectedCourse; ?>">
            <input type="hidden" name="subject" value="<?php echo $selectedSubject; ?>">
            <input type="hidden" name="topic" value="<?php echo $selectedTopic; ?>">
            <input type="hidden" name="difficulty" value="<?php echo $selectedDifficulty; ?>">
            <input type="submit" name="submit_answers" value="Submit Answers">
        </form>
    </body>

    </html>
<?php
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_answers'])) {
    $selectedAnswers = $_POST['answers'];
    $user_id = $_SESSION['userid'];
    $exam_id = 1;
    // Check if all questions are answered
    $answeredQuestionsCount = count($selectedAnswers);
    if ($answeredQuestionsCount !== $expectedQuestionsCount) {
        echo "Please answer all questions before submitting.";
        exit;
    }

    foreach ($selectedAnswers as $mcq_id => $selectedAnswer) {
        // Insert answer into exam_question table
        $sql_insert_answer = "INSERT INTO exam_question (exam_id, mcq_id, user_answer)
                              VALUES ('$exam_id', '$mcq_id', '$selectedAnswer')";
        if ($conn->query($sql_insert_answer) !== TRUE) {
            echo "Error inserting answer: " . $conn->error;
            exit;
        }
    }

    foreach ($selectedAnswers as $mcq_id => $selectedAnswer) {
        // Get correct answer from database
        $sql_correct_answer = "SELECT correct_answer FROM mcq WHERE mcq_id = '$mcq_id'";
        $result_correct_answer = $conn->query($sql_correct_answer);
        $row = $result_correct_answer->fetch_assoc();
        $correctAnswer = $row['correct_answer'];

        if ($selectedAnswer == $correctAnswer) {
            // Increment total marks
            $totalMarks++;
        }
    }

    $sql_store_result = "INSERT INTO result (user_id, exam_id, total_marks) VALUES ('$user_id', '$exam_id', '$totalMarks')";
    if ($conn->query($sql_store_result) === TRUE) {
        // Redirect to view their result
        header("Location: view_result.php");
        exit;
    } else {
        echo "Error storing result: " . $conn->error;
        exit;
    }
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MCQ Exam</title>
    </head>

    <body>
        <h1>MCQ Exam</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="course">Select Course:</label>
            <select name="course" id="course">
                <?php
                // selecting course options
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['course_id'] . "'>" . $row['course_name'] . "</option>";
                }
                ?>
            </select><br><br>

            <label for="subject">Select Subject:</label>
            <select name="subject" id="subject">
                <?php
                // selecting subject options
                while ($row = $result_subjects->fetch_assoc()) {
                    echo "<option value='" . $row['subject_id'] . "'>" . $row['subject_name'] . "</option>";
                }
                ?>
            </select><br><br>

            <label for="topic">Select Topic:</label>
            <select name="topic" id="topic">
                <?php
                // selecting topic options
                while ($row = $result_topics->fetch_assoc()) {
                    echo "<option value='" . $row['topic_id'] . "'>" . $row['topic_name'] . "</option>";
                }
                ?>
            </select><br><br>

            <label for="difficulty">Select Difficulty:</label>
            <select name="difficulty" id="difficulty">
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select><br><br>

            <input type="submit" name="submit" value="Start Exam">
        </form>
    </body>

    </html>
<?php
}
$conn->close();
?>