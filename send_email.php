<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Your Email Address
    $receiving_email_address = 'info@weversecreation.com'; 

    // 2. Collect and Sanitize Form Data
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST["subject"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // 3. Basic Validation
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back to contact page with an error message
        header("Location: contact.html?status=error&message=Please fill in all required fields and ensure email is valid.");
        exit;
    }

    // 4. Prepare Email Content
    $email_subject = "New Contact Form from We Verse Creation Website: " . ($subject ? $subject : "No Subject");
    $email_body = "You have received a new message from your website contact form.\n\n" .
                  "Here are the details:\n\n" .
                  "Name: $name\n\n" .
                  "Email: $email\n\n" .
                  "Subject: " . ($subject ? $subject : "N/A") . "\n\n" .
                  "Message:\n$message";

    // 5. Set Email Headers
    // Important: Use an email address associated with your domain for 'From' to avoid spam filters.
    // E.g., 'noreply@yourdomain.com'
    $headers = "From: info@weversecreation.com\r\n"; 
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

    // 6. Send Email
    if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
        // Success: Redirect to contact page with a success message
        header("Location: contact.html?status=success&message=Thank you for contacting us! Your message has been sent successfully.");
        exit;
    } else {
        // Failure: Redirect to contact page with an error message
        header("Location: contact.html?status=error&message=Oops! Something went wrong, and we couldn't send your message.");
        exit;
    }

} else {
    // If someone tries to access this script directly without submitting the form
    header("Location: contact.html");
    exit;
}
?>