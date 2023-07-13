<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$db_connection = new Database();

$conn = $db_connection->dbConnection();




function msg($success, $status, $message, $extra = [])
{

    return [
        "success" => $success,
        "status" => $status,
        "message" => $message,
        "extra" => $extra
    ];
}


$data = json_decode(file_get_contents("php://input"));



$returnData = [];


if ($_SERVER["REQUEST_METHOD"] != "POST") :
    $returnData = msg(0, 404, "Page Not Found!");


elseif (
    !isset($data->email)
    || !isset($data->password)
    || empty(trim($data->email))
    || empty(trim($data->password))
) :

    $fields = ["fields" => ["email", "password"]];
    $returnData = msg(0, 422, "Please Fill in all Required Fields!", $fields);


else :

    $email = trim($data->email);
    $password = trim($data->password);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        $returnData = msg(0, 422, 'Invalid Email Address!');

    elseif (strlen($password) < 8) :
        $returnData = msg(0, 422, 'Your password must be at least 8 characters long!');

    else :
        try {

            $sql = "select * from users where email = :email";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount()) :

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $check_password = password_verify($password, $row['password']);

                if ($check_password) :

                    $jwt = new JwtHandler();

                    $iss = "http://localhost/php_auth_api/'";

                    $token = $jwt->jwtEncodeData(
                        $iss,
                        array("user_id" => $row['id'])
                    );


                    $returnData = [
                        'success' => 1,
                        'message' => 'You have successfully logged in.',
                        'token' => $token
                    ];

                else :
                    $returnData = msg(0, 422, 'Invalid Password!');
                endif;

            else :
                $returnData = msg(0, 422, 'Invalid Email Address!');

            endif;
        } catch (PDOException $e) {
            $returnData = msg(0, 500, $e->getMessage());
        }

    endif;


endif;

echo json_encode($returnData);
