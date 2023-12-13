<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include 'connection.php';
    

    $username = $_POST["username"];
    $password = $_POST["password"];
    

    $recaptchaResponse = $_POST['g-recaptcha-response'];


    // $secretKey = '6LcAEQIjAAAAAK7yH0mD0wQcBvNmPI-p1E6VQL5z';
    $secretKey = '6LdDeiwpAAAAAAAAxXWYfPt1x2zNLfF1ithKWFfC';
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse,
    ];

    $options = [
        'http' => [
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $recaptchaResult = json_decode($response, true);

  
    if ($recaptchaResult['success']) {

        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc(); 
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["fullname"] = $row["fullname"]; 
            $_SESSION["type"] = $row["type"];

            if ($_SESSION["type"] == "super_admin") {
                header("Location: ../dashboard.php");
                $_SESSION['success'] = "You are now logged in as Administrator.";
            } else {
                header("Location: ../dashboard.php");
                $_SESSION['success'] = "You are now logged in as an Administrator.";
            }
        }

    } else {
        header("Location: ../login.php?error=captcha");
        $_SESSION['error_msg'] = "Captcha required!";
        ?>
        
        <?php
    }
    $conn->close();
}

?>
