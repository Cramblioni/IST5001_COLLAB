<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "invalid method";
    http_response_code(405); // Method not allowed
    exit;
}

// Getting our user info
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];
} else {
    echo "not logged in";
    http_response_code(401); // Unauthorized
    exit;
}

if (!isset($_GET["qid"])) { 
    echo "Missing question `qid`";
    http_response_code(406); // Not Accaptable
    exit;
}
$qid = $_GET["qid"];
if (!isset($_GET["aid"])) { 
    echo "Missing answer `aid`";
    http_response_code(406); // Not Acceptable
    exit;
}
$aid = $_GET["aid"];

// General conenction
$conn = mysqli_connect("localhost", "Client", "magic", "CyberSecurityWebsite");
if (mysqli_connect_errno()) {
    echo ("Internal Error: ". mysqli_connect_error());
    http_response_code(500); // Internal Server Error
    exit;
}

$query = mysqli_prepare($conn,
                       "INSERT INTO `UserResponses` "
                      ."(`UserID`, `QuestionID`, `SelectedAnswerID`, `TimeAnswered`) "
                      ."VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
$query->bind_param("sss", $user, $qid, $aid);

if (!mysqli_stmt_execute($query)) {
    echo ("Internal Error: ". mysqli_connect_error());
    http_response_code(500); // Internal Server Error
    exit;
}

http_response_code(201); // Created
?>
