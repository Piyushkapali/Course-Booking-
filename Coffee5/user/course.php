<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Barista Courses - Coffee Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Add Bootstrap CSS for better styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add custom styles -->
    <style>
        .course-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .course-card:hover {
            transform: translateY(-5px);
        }
        .package-features {
            list-style: none;
            padding-left: 0;
        }
        .package-features li {
            margin-bottom: 8px;
            padding-left: 25px;
            position: relative;
        }
        .package-features li:before {
            content: "✓";
            color: #28a745;
            position: absolute;
            left: 0;
        }
        .booking-form {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main class="container mt-5">
        <h1 class="text-center mb-5">Advanced Barista Training Programs</h1>

        <!-- Display Messages -->
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Basic Package -->
            <div class="col-md-4">
                <div class="course-card">
                    <img src="../image/img3.webp" class="img-fluid rounded mb-3" alt="Basic Course">
                    <h3>Basic Barista Package</h3>
                    <p class="text-muted">Perfect for beginners</p>
                    <h4 class="price">Rs. 15,000/-</h4>
                    <ul class="package-features">
                        <li>7 Days Training</li>
                        <li>Basic Coffee Theory</li>
                        <li>Espresso Basics</li>
                        <li>Simple Latte Art</li>
                        <li>Certificate of Completion</li>
                    </ul>
                    <button class="btn btn-primary w-100 book-now" data-package="Basic" data-price="15000">Book Now</button>
                </div>
            </div>

            <!-- Advanced Package -->
            <div class="col-md-4">
                <div class="course-card">
                    <img src="../image/barista.jpg" class="img-fluid rounded mb-3" alt="Advanced Course">
                    <h3>Advanced Barista Package</h3>
                    <p class="text-muted">For serious enthusiasts</p>
                    <h4 class="price">Rs. 25,000/-</h4>
                    <ul class="package-features">
                        <li>15 Days Training</li>
                        <li>Advanced Coffee Theory</li>
                        <li>Complex Espresso Techniques</li>
                        <li>Advanced Latte Art</li>
                        <li>Manual Brewing Methods</li>
                        <li>Coffee Roasting Introduction</li>
                        <li>Professional Certificate</li>
                    </ul>
                    <button class="btn btn-primary w-100 book-now" data-package="Advanced" data-price="25000">Book Now</button>
                </div>
            </div>

            <!-- Professional Package -->
            <div class="col-md-4">
                <div class="course-card">
                    <img src="../image/train.jpg" class="img-fluid rounded mb-3" alt="Professional Course">
                    <h3>Professional Barista Package</h3>
                    <p class="text-muted">Master level training</p>
                    <h4 class="price">Rs. 40,000/-</h4>
                    <ul class="package-features">
                    <li>30 Days Training</li>
                        <li>Master Level Coffee Theory</li>
                        <li>Advanced Espresso Mastery</li>
                        <li>Professional Latte Art</li>
                        <li>All Brewing Methods</li>
                        <li>Coffee Roasting & Blending</li>
                        <li>Business Management</li>
                        <li>International Certification</li>
                        <li>Job Placement Assistance</li>
                    </ul>
                    <button class="btn btn-primary w-100 book-now" data-package="Professional" data-price="40000">Book Now</button>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div id="bookingForm" class="booking-form" style="display: none;">
            <h3 class="mb-4">Book Your Course</h3>
            <form action="process_booking.php" method="POST">
                <input type="hidden" id="selectedPackage" name="package">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="preferred_date" class="form-label">Preferred Start Date</label>
                        <input type="date" class="form-control" id="preferred_date" name="preferred_date" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="preferred_time" class="form-label">Preferred Time Slot</label>
                        <select class="form-select" id="preferred_time" name="preferred_time" required>
                            <option value="">Choose a time slot</option>
                            <option value="morning">Morning (9:00 AM - 12:00 PM)</option>
                            <option value="afternoon">Afternoon (1:00 PM - 4:00 PM)</option>
                            <option value="evening">Evening (5:00 PM - 8:00 PM)</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="message" class="form-label">Special Requirements/Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit Booking</button>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="social-links">
        <a href="https://www.facebook.com/piyush.kapali.9"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/piyush.kapali"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/@piyushkapali3821"><i class="fab fa-youtube"></i></a>
        </div>
        <p>&copy; 2025 Coffee Shop. All rights reserved.</p>
    </footer>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add Bootstrap JS and its dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to show booking form and set package
        function showBookingForm(packageName, packagePrice) {
            // Show the booking form
            document.getElementById('bookingForm').style.display = 'block';
            
            // Set the selected package in the hidden input
            document.getElementById('selectedPackage').value = packageName + ' - Rs. ' + packagePrice;

            // Smooth scroll to booking form
            document.getElementById('bookingForm').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }

        // Add click event listeners to all "Book Now" buttons
        document.addEventListener('DOMContentLoaded', function() {
            const bookNowButtons = document.querySelectorAll('.book-now');
            bookNowButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const packageName = this.getAttribute('data-package');
                    const packagePrice = this.getAttribute('data-price');
                    showBookingForm(packageName, packagePrice);
                });
            });

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('preferred_date').min = today;
        });
    </script>
</body>
</html>