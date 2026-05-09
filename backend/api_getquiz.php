<?php
// Getting our user info
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];
} else {
    // We should redirect to the sign up/in page here
    $user = null;
}

if (!isset($_GET["id"])) {
    exit("Missing Quiz `id`");
}
$id = $_GET["id"];
header("Content-Type: application/json");

// General conenction
$conn = mysqli_connect("localhost", "Client", "magic", "CyberSecurityWebsite");
if (mysqli_connect_errno()) {
    exit("Error: ". mysqli_connect_error());
}

// === Actually getting the data === //

$quiz_query = mysqli_prepare($conn,
    "SELECT `QuizTitle`, `Description` FROM `quiz` WHERE `QuizId` = ?"
);
$quiz_query->bind_param("s", $id);

if (!mysqli_stmt_execute($quiz_query)) {
    exit("". mysqli_error($conn));
}

$quiz_row = $quiz_query->get_result()->fetch_row();
$quiz = new stdClass();
$quiz->title = $quiz_row[0];
$quiz->description = $quiz_row[1];
$quiz->questions = array();

function getAnswers($conn, $question_id) {
    $answers = array();
    $answers_query = mysqli_prepare($conn,
        "SELECT `AnswerText`, `IsCorrect` FROM `Answers` WHERE `QuestionID` = ?" 
    );
    $answers_query->bind_param("s", $question_id);

    if (!mysqli_stmt_execute($answers_query)) {
        exit("". mysqli_error($conn));
    }

    $answers_result = $answers_query->get_result();
    $answer_row = $answers_result->fetch_row();
    while ($answer_row !== null) {
        $answer = new stdClass();
        $answer->text = $answer_row[0];
        $answer->correct = $answer_row[1];

        $answers[] = $answer;
        $answer_row = $answers_result->fetch_row();
    }
    //$answers_result->free_result();
    return $answers;
}

$questions_query = mysqli_prepare($conn,
    "SELECT `QuestionId`,`QuestionText`, `DifficultyLevel` FROM `Questions` WHERE `QuizId` = ?"
);
$questions_query->bind_param("s", $id);

if (!mysqli_stmt_execute($questions_query)) {
    exit("". mysqli_error($conn));
}

$questions_result = $questions_query->get_result();
$question_row = $questions_result->fetch_row();
while ($question_row !== null) {
    $question = new stdClass();
    $question->text = $question_row[1];
    $question->difficulty = $question_row[2];
    $question->answers = getAnswers($conn, $question_row[0]);

    // appending the question to the array
    $quiz->questions[] = $question;
    $question_row = $questions_result->fetch_row();
}

echo json_encode($quiz);
?>
