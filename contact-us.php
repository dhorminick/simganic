<?php
    session_start();
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    # dbconn
    $dbconn = include '_layout/_dbconnection.php';
    if ($dbconn) {}else{ header("Location: 404");}
    

    if (!isset($_SESSION['loggedin'])) {
        
    }else{
        $_user_email_address = $_SESSION['email'];
        $_user_name = $_SESSION['username'];
        include '_layout/_user_details.php';
    }

    $messages = [];

    if (isset($_POST["send-message"])) {
        if ($_POST["name"] != null && $_POST["email"] != null && $_POST["message"] != null && $_POST["subject"] != null) {
            $name = trim(strip_tags(htmlspecialchars($_POST["name"])));
            $email = trim(strip_tags(htmlspecialchars($_POST["email"])));
            $message = trim(strip_tags(htmlspecialchars($_POST["message"])));
            $subject = trim(strip_tags(htmlspecialchars($_POST["subject"])));

            # send mail
            require '_mailer/PHPMailer.php';
            require '_mailer/SMTP.php';
            require '_mailer/Exception.php';
                        
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'mail.tedmaniatv.com'; # prolly use simganic smtp
            $mail->SMTPAuth = true;
            $mail->Username = 'admin@tedmaniatv.com'; # paste one generated by Mailtrap
            $mail->Password = '@lhZkJC_9*p{'; # paste one generated by Mailtrap
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            
            $mail->setFrom($email, $name);
            $mail->addReplyTo($email, $name);
            $mail->addAddress('support@simganic.com', 'SimGanic'); # name is optional
            
            $mail->Subject = $subject;
            $mail->isHTML(true);
            
            $mail->Body = $message;
            $mail->AltBody = $message;
            
            # $mail->send();
            if($mail->send()){
                array_push($messages, "Mail Sent Succesfully.");
            }else{ 
                array_push($messages, "Error 501! Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        } else {
            array_push($messages, "Error 402! Mail Error.");
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Contact Us - SimGanic</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome-6/css/all.css">

<!-- CSS Libraries -->

<!-- Template CSS -->
<link rel="stylesheet" href="assets/css/style.min.css">
<link rel="stylesheet" href="assets/css/components.min.css">
<link rel="stylesheet" href="assets/css/mystyle.css">
</head>

<body class="layout-1">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        
        <?php include '_layout/_header_sidebar.php';?>

        <!-- Start app main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h4>Contact Us</h4>
                </div>
                <div class="section-body" style="padding-top:20px !important;">
                <?php if (count($messages) > 0) : ?>
                <div class="alert-div">
                <?php foreach ($messages as $error) : ?>
                    <div class="alert alert-primary alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert"><span>×</span></button>
                            <?php echo $error ?>
                        </div>
                    </div>
                <?php endforeach ?>
                </div>
                <?php endif ?>
                <div>
                    <h5>Have an urgent request, chat with us on whatsapp @ <a href="">090-768-76557</a> or mail us @</h5>
                </div><br>
                    <form method="post" action="">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="Name">Full Name:</label>
                                <input type="text" class="form-control" name="name" placeholder="Your Full Name..." <?php if (isset($_SESSION['loggedin'])) { echo 'value="'.ucwords($_firstname).' '.ucwords($_lastname).'" readonly';}else{} ?>>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Email">Email Address:</label>
                                <input type="email" class="form-control" name="email" placeholder="Your Email Address..." <?php if (isset($_SESSION['loggedin'])) {echo 'value="'.$_SESSION["email"].'" readonly';}else{} ?>>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Email">Mail Subject:</label>
                            <input type="text" class="form-control" name="subject" placeholder="Your Email Subject..." required>
                        </div>

                        <div class="form-group">
                            <label for="Message">Mail Message:</label>
                            <textarea class="form-control" name="message" placeholder="Type your message..." data-height="50"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn-submit-message btn btn-lg btn-primary" name="send-message">
                                Send Message <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <style>
            .form-control:focus{
                /*color: black;*/
            }
            .btn-submit-message{
                text-transform: uppercase;
                font-weight: bolder;
            }
            textarea.form-control {
                height: 170px !important;
                resize: none;
            }
        </style>

        <!-- Start app Footer part -->
        <?php include '_layout/_footer.php';?>
    </div>
</div>

<!-- General JS Scripts -->
<script src="assets/bundles/lib.vendor.bundle.js"></script>
<script src="js/CodiePie.js"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="js/scripts.js"></script>
<script src="js/custom.js"></script>
</body>


</html>