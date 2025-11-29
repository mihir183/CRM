<?php
session_start();
include '../Pages/db.php'; // your DB connection
include '../Pages/secret.php'; // your DB connection

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

if (isset($_GET['id'])) {
    $ticketId = $_GET['id'];

    if ($conn) {
        // Get ticket details
        $stmt = $conn->prepare("SELECT ticket_client, client_email, product, complain FROM tickets WHERE t_id = ?");
        $stmt->bind_param("i", $ticketId);
        $stmt->execute();
        $result = $stmt->get_result();
        $ticket = $result->fetch_assoc();
        $stmt->close();

        if ($ticket) {
            // Update status to Completed
            $stmt = $conn->prepare("UPDATE tickets SET status = 'Completed' WHERE t_id = ?");
            $stmt->bind_param("i", $ticketId);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Ticket #$ticketId marked as Completed.";

                // Send email via PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // or your SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = $sender; // SMTP username
                    $mail->Password = $EPassword; // SMTP password or App Password for Gmail
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom('support@yourdomain.com', 'Support Team');
                    $mail->addAddress($ticket['client_email'], $ticket['ticket_client']);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = "Your Ticket #$ticketId has been Completed";

                    $mail->Body = '
                        <!DOCTYPE html>
                        <html>
                        <head>
                        <meta charset="UTF-8">
                        <title>Ticket Completed</title>
                        <style>
                            body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                            }
                            .container {
                            max-width: 600px;
                            margin: 20px auto;
                            background-color: #ffffff;
                            padding: 20px;
                            border-radius: 8px;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                            }
                            h2 {
                            color: #333333;
                            }
                            p {
                            color: #555555;
                            line-height: 1.6;
                            }
                            .ticket-details {
                            background-color: #f0f0f0;
                            padding: 15px;
                            border-radius: 5px;
                            margin: 15px 0;
                            }
                            .footer {
                            text-align: center;
                            font-size: 12px;
                            color: #999999;
                            margin-top: 20px;
                            }
                            .btn {
                            display: inline-block;
                            padding: 10px 20px;
                            margin-top: 10px;
                            background-color: #4CAF50;
                            color: #ffffff;
                            text-decoration: none;
                            border-radius: 5px;
                            }
                        </style>
                        </head>
                        <body>
                        <div class="container">
                            <h2>Ticket #' . $ticketId . ' Completed</h2>
                            <p>Hello <strong>' . $ticket['ticket_client'] . '</strong>,</p>
                            <p>Your ticket regarding the product "<strong>' . $ticket['product'] . '</strong>" has been successfully marked as <strong>Completed</strong>.</p>

                            <div class="ticket-details">
                            <h4>Complain Details:</h4>
                            <p>' . $ticket['complain'] . '</p>
                            </div>

                            <p>Thank you for your patience and for contacting our support team.</p>
                            <a href="https://yourdomain.com/tickets" class="btn">View Your Tickets</a>

                            <div class="footer">
                            &copy; ' . date("Y") . ' Support Team. All rights reserved.
                            </div>
                        </div>
                        </body>
                        </html>
                        ';


                    $mail->send();
                    // Optional: $_SESSION['success'] .= " Email sent to client.";
                } catch (Exception $e) {
                    $_SESSION['error'] = "Ticket updated but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            } else {
                $_SESSION['error'] = "Failed to update ticket status.";
            }

            $stmt->close();
        } else {
            $_SESSION['error'] = "Ticket not found.";
        }
    }
} else {
    $_SESSION['error'] = "Invalid ticket ID.";
}

// Redirect back to tickets page
header("Location: tickets.php");
exit();
?>