<?php
session_start();
include 'connection.php';

// Include the Google API client library
require __DIR__ . '../../vendor/autoload.php'; // Adjust the path as needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_date = $_POST['event_date'];
    $outputDate = date('Y/m/d', strtotime($event_date));
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];

    $dateCheckQuery = "SELECT COUNT(*) AS event_count FROM events_tbl WHERE event_date = '$event_date'";
    $dateResult = $conn->query($dateCheckQuery);

    if ($dateResult) {
        $eventCount = $dateResult->fetch_assoc()['event_count'];
        if ($eventCount > 0) {
            $_SESSION['error'] = "An event already exists for the selected date.";
        } else {
            // Assuming you have logic for handling image upload here
            $imageFileName = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));

            if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $uploadDir = 'events_banner/';
                $imageFile = $uploadDir . uniqid() . '.' . $imageFileType;

                if (move_uploaded_file($imageTmpName, $imageFile)) {

                    $serviceAccountFilePath = 'config/googleCalendar.json';

                    // Set up the Google API client with the service account credentials
                    $client = new Google_Client();
                    $client->setAuthConfig($serviceAccountFilePath);
                    $client->addScope(Google\Service\Calendar::CALENDAR);
                    $client->setAccessType('offline');
                    $client->getAccessToken();
                    $client->getRefreshToken();

                    // Set up the Google Calendar service
                    $service = new Google\Service\Calendar($client);

                    // Submit the event to Google Calendar
                    $calendarId = 'padayhagjessa@gmail.com';

                    // Embedding an image in the event description
                     
                    $eventDescriptionWithImage = '<p><strong>' . $event_name . '</strong></p>
                    <p>' . $event_description . '</p>
                    <p>Event Time: ' . $event_date . '</p>' .
                    '<p>Event Calendar Link: ' . $calendarLink . '</p>';

                    $event = new Google\Service\Calendar\Event(array(
                        'summary' => $event_name,
                        'description' => $event_description,
                        'start' => array(
                            'dateTime' => $event_date . 'T00:00:00',
                            'timeZone' => 'Asia/Manila',
                        ),
                        'end' => array(
                            'dateTime' => $event_date . 'T23:59:59',
                            'timeZone' => 'Asia/Manila',
                        ),
                    ));

                    $event = $service->events->insert($calendarId, $event);

                    $img = "http://blmpccoop.test/functions/" . $imageFile;

                    $imgURL = uploadImageToImgBB("91bf04e31fbba83f6fe41f819d1d345f", $img);

                    if ($event) {
                        // Event added to Google Calendar, now insert into the database
                        $sql = "INSERT INTO events_tbl(event_name, event_date, event_description, image_path, google_calendar_link) VALUES('$event_name', '$event_date', '$event_description', '$imageFile', '$event->htmlLink')";

                        if ($conn->query($sql) === TRUE) {
                            // Database insertion successful

                            // Notify users by email
                            notifyUsersByEmail($event_name, $event_description, $event->start->dateTime, $event->htmlLink, $imgURL);

                            $_SESSION['success'] = "Event added to Google Calendar and database.";
                        } else {
                            $_SESSION['error'] = "Error: " . $conn->error;
                        }
                    } else {
                        $_SESSION['error'] = "Error creating event in Google Calendar.";
                    }
                } else {
                    $_SESSION['error'] = "Error uploading image.";
                }
            } else {
                $_SESSION['error'] = "Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.";
            }
        }
    }

    header("Location: ../events.php");
    exit;
}
// Function to send email notifications
function notifyUsersByEmail($eventTitle, $eventDescription, $eventDateTime, $calendarLink, $imgURL)
{
    include 'connection.php';

    $mail = new PHPMailer();

    try { 
 
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'slpmjytn@gmail.com';
        $mail->Password = 'tonh hiqh tgvo iuvc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // Recipients (replace with actual user emails)
        $dateCheckQuery = "SELECT email FROM members_tbl WHERE 1";
        $dateResult = $conn->query($dateCheckQuery); 



        // Loop through database results if applicable
        while ($row = $dateResult->fetch_assoc()) {
            $recipientEmail = $row['email'];

            // Set recipient for the current iteration
            $mail->addAddress($recipientEmail);

            // Content
            $mail->setFrom('info@blmpccoop.com', 'BLMPC COOP');
            $mail->isHTML(true);
            $mail->Subject = 'New Event: ' . $eventTitle;

             

            // Embed the image in the email body
            $mail->Body    = '<p><strong>' . $eventTitle . '</strong></p>';
            $mail->Body    .= '<p>' . $eventDescription . '</p>';
            $mail->Body    .= '<p>Event Time: ' . $eventDateTime . '</p>'; 
            $mail->Body    .= '<p><img src="' . $imgURL . '" alt="Event Image" /></p>'; 

            // Send email for the current recipient
            $mail->send();

            // Clear recipient and attachments for the next iteration
            $mail->clearAddresses();
        }

        echo 'Email notifications sent successfully.';

    } catch (Exception $e) {
        echo 'Email notification failed. Error: ', $mail->ErrorInfo;
    }
}
   
function uploadImageToImgBB($apiKey, $imagePath) {
    // Create a cURL handle
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $apiKey);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    // Add the image file to the cURL request
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'image' => base64_encode(file_get_contents($imagePath)),
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Close cURL handle
    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if the upload was successful
    if ($data && isset($data['data']['url'])) {
        return $data['data']['url'];
    } else {
        return false;
    }
}

 
?>
