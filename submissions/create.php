<?php

require "../lib/database.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    header("Location: /");

    exit();
}

// session_start();

// $token = filter_input(INPUT_POST, "csrf_token", FILTER_UNSAFE_RAW);

// if (!$token || $token !== $_SESSION["csrf_token"]) {
//     http_response_code(405);

//     exit;
// }

function validateInput() {
    $required = filter_input_array(INPUT_POST, [
        "job_title" => FILTER_UNSAFE_RAW,
        "country_id" => FILTER_UNSAFE_RAW,
        "region_id" => FILTER_UNSAFE_RAW,
    ]);

    if (is_null($required) || in_array(null, $required, true)) {
        throw new Exception("Error Processing Request", 1);
    }

    $optional = filter_input_array(INPUT_POST, [ "job_additional_info" => FILTER_UNSAFE_RAW ]);

    return [
        ...$required,
        ...$optional,
    ];
}

function saveData($data) {
    $db = connectToDb();
    $query = "INSERT INTO jobs(job_title, country_id, region_id, job_additional_info) VALUES (:job_title, :country_id, :region_id, :job_additional_info)";
    $statement = $db->prepare($query);
    $statement->execute($data);

    return;
}

function sendMail($input) {
    $to = "jobform@voices.com";
    $subject = "Job Form Submission";
    $message = "
        Job Title: {$input["job_title"]} \n
        Job Country: {$input["job_title"]} \n
        Job Region: {$input["job_title"]} \n
    ";

    if ($input["job_additional_info"] === "") {
        $message += "Additional Info: {$input["job_additional_info"]}";
    }

    mail($to, $subject, $message);

    return;
}

try {
    $input = validateInput();

    saveData($input);

    sendMail($input);

    http_response_code(201);

    $response = json_encode([ "message" => "Success" ]);
    echo($response);
} catch (Exception $e) {
    $response = json_encode([ "message" => $e->getMessage() ]);
    echo($response);

    http_response_code(500);
}
