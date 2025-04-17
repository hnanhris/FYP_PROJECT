<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/262086238a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Main Content -->
<div class="container" style="margin-top: 100px; min-height: 70vh;">
    <div class="row justify-content-center py-5">
        <div class="col-lg-8">
            <h1 class="text-center mb-5">Contact Us</h1>
            
            <div class="row mb-5">
                <div class="col-md-4 text-center mb-4">
                    <i class="bi bi-geo-alt-fill display-4 text-primary mb-3"></i>
                    <h4>Visit Us</h4>
                    <p>123 Fashion Street<br>Kuala Lumpur, Malaysia</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <i class="bi bi-telephone-fill display-4 text-primary mb-3"></i>
                    <h4>Call Us</h4>
                    <p>+60 12-345 6789<br>Mon-Fri, 9am-6pm</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <i class="bi bi-envelope-fill display-4 text-primary mb-3"></i>
                    <h4>Email Us</h4>
                    <p>info@zyzaismail.com<br>support@zyzaismail.com</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Send us a Message</h3>
                    <form action="server/send_message.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>