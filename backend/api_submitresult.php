<?php

function postResult($conn, $user) {

    // Checking if parameters are present
    if (!isset($_GET["qid"])) { 
        echo "Missing question `qid`";
        http_response_code(406); // Not Accaptable
        exit;
    }
    if (!isset($_GET["aid"])) { 
        echo "Missing answer `aid`";
        http_response_code(406); // Not Acceptable
        exit;
    }
    $qid = $_GET["qid"];
    $aid = $_GET["aid"];

    // Inserting the item into the database.
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
    exit;
}

function getResult($conn, $user) {
    // Checking if parameters are present
    if (!isset($_GET["qid"])) { 
        echo "Missing question `qid`";
        http_response_code(406); // Not Accaptable
        exit;
    }
    $qid = $_GET["qid"];
    $query = mysqli_prepare($conn,
                       "SELECT `SelectedAnswerID` FROM `UserResponses` "
                      ."WHERE `UserID` = ? AND `QuestionID` = ?");
    $query->bind_param("ss", $user, $qid);

    if (!mysqli_stmt_execute($query)) {
        echo ("Internal Error: ". mysqli_connect_error());
        http_response_code(500); // Internal Server Error
        exit;
    }
    $result = $query->get_result()->fetch_row();
    header("Content-Type: application/json");
    echo json_encode($result[0]);
    http_response_code(200); // Created
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


$conn = mysqli_connect("localhost", "Client", "magic", "CyberSecurityWebsite");
if (mysqli_connect_errno()) {
    echo ("Internal Error: ". mysqli_connect_error());
    http_response_code(500); // Internal Server Error
    exit;
}

// Deciding how to act based on how the client wants us to act
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    postResult($conn, $user);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getResult($conn, $user);
}
echo "invalid method";
http_response_code(405); // Method not allowed
exit;
?>
