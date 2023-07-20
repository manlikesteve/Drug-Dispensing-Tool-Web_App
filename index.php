<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabib Health - Home</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="navbar">
    <img class="logo" src="images/_Pngtree_medical_health_logo_4135858-removebg-preview.png" alt="Logo">
    <ul>
        <li><a href="#welcome">Tabib Health - Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#testimonials">What Our Users Say</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
    <div class="auth-buttons">
        <?php
        if (isset($_SESSION['username'])) {
            // User is logged in, display user details and logout button
            echo '<div class="user-info">';
            if (isset($_SESSION['profile_picture'])) {
                // Display the profile picture if available
                echo '<img src="' . $targetDirectory . $_SESSION['profile_picture'] . '" alt="Profile Picture" class="profile-picture">';
            } else {
                // Display a default profile picture if no picture is available
                echo '<img src="images/blank-profile-picture-973460_1280.webp" alt="Default Profile Picture" class="profile-picture">';
            }
            echo '<span>Welcome, ' . $_SESSION['username'] . '</span>
            <span class="account-type">(' . $_SESSION['userType'] . ')</span>
            <a class="logout-btn" href="logout.php">Sign Out</a>
        </div>';
        } else {
            // User is not logged in, display login and signup buttons
            echo '<button class="login-btn" onclick="location.href=\'login.php\'">Login</button>
            <button class="signup-btn" onclick="location.href=\'signup.php\'">Sign Up</button>';
        }
        ?>
    </div>
</div>

<div class="main-content" id="welcome">
    <div class="welcome-section">
        <div class="text">
            <h2>We Are <br> Tabib Health</h2>
            <p>A Drug Dispensing Tool <br> designed to help patients, doctors, and pharmacists
                <br> manage prescriptions, medications, and medical records efficiently and securely.</p>
            <a href="signup.php" class="get-started-btn">Get Started</a>
        </div>
        <div class="image">
            <img src="images/pngtree-online-medical-health-consultation-doctor-vector-illustration-pattern-element-png-image_5779867-removebg-preview.png" alt="Image 1">
        </div>
        <div id="welcome-background-overlay"></div>
    </div>
    <!-- About Us section -->
    <section class="about-section" id="about">
        <h3 >Heard About Us?</h3>

        <!-- Add an image to the About Us section -->
        <img src="images/Pharmacy%20M%20by%20CAAN%20Architecten%20_%20Dezeen.jpeg" alt="About Us Image">

        <p>Welcome to <u>Tabib Health</u>, <br><br>Your trusted partner in healthcare management.
            At Tabib Health, we believe in empowering patients, doctors, and pharmacists with innovative tools
            to streamline prescription management, drug dispensing, and enhance medical record security.
            <br><br>Our <u>User-friendly Drug Dispensing Tool</u> allows patients to conveniently access their prescriptions,
            while doctors can efficiently manage medication plans.
            Join us on our journey to revolutionize healthcare, one prescription at a time.
            Your well-being is our priority, and with Tabib Health, you're in safe hands.
    </section>
    <!--Services Section-->
    <div class="services-section" id="services">
        <h2>Our Services</h2>
        <div class="services-cards">
            <div class="service-card">
                <i class="fas fa-user-md"></i>
                <h3>Modern-day Telemedicine</h3>
                <p>Connect with experienced doctors online for remote consultations.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-pills"></i>
                <h3>Medication Management</h3>
                <p>Efficiently manage your prescriptions and medications in one place.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-file-medical-alt"></i>
                <h3>Electronic Health Records</h3>
                <p>Securely store and access your medical records anytime, anywhere.</p>
            </div>
        </div>
        <div class="services-cards-2">
            <div class="service-card">
                <i class="fas fa-user-md"></i>
                <h3>Drug & Medication Dispensing</h3>
                <p>Receive electronic prescriptions from doctors, verify the prescription details, prepare the medications</p>
            </div>
            <div class="service-card">
                <i class="fas fa-pills"></i>
                <h3>Medication Alerts and Reminders</h3>
                <p>Set up alerts and reminders for patients, notifying them about upcoming medication refills</p>
            </div>
            <div class="service-card">
                <i class="fas fa-file-medical-alt"></i>
                <h3>Appointment Scheduling</h3>
                <p>Schedule appointments with your healthcare providers or specialists</p>
            </div>
        </div>
    </div>
<!--    Numbers Section-->
    <div class="numbers-section" id="numbers">
        <div class="number-card">
            <h3><span id="patientsCount">0</span>+</h3>
            <p>Patients Benefiting From Tabib Health</p>
        </div>
        <div class="number-card">
            <h3><span id="countriesCount">0</span>+</h3>
            <p>Countries Served</p>
        </div>
        <!-- Add more number-cards for other metrics if needed -->
    </div>

<!--    Testimonials-->
    <section class="testimonials-section" id="testimonials">
        <h2>Testimonials</h2>
        <div class="testimonials-container"> <!-- Add a wrapper for the testimonial cards -->
            <div class="testimonial-card">
                <!-- Testimonial content for the first card -->
                    <img src="images/profile1.jpeg" alt="Profile 1" class="profile-picture">
                    <div class="testimonial-text">
                        <p>"Tabib Health has been a lifesaver for me! Managing my medications and prescriptions has never been easier.
                            The app's user-friendly interface and secure features give me peace of mind."</p>
                        <p class="testimonial-author">- John Doe</p>
                    </div>
            </div>

            <div class="testimonial-card">
                <!-- Testimonial content for the second card -->
                <img src="images/profile2.png" alt="Profile 2" class="profile-picture">
                <div class="testimonial-text">
                    <p>"As a doctor, I highly recommend Tabib Health to all my patients.
                        It streamlines the prescription process and helps me stay organized with my patients' medical records.
                        A fantastic tool!"</p>
                    <p class="testimonial-author">- Jack Doe</p>
                </div>
            </div>

            <div class="testimonial-card">
                <!-- Testimonial content for the third card -->
                <img src="images/profile3.jpeg" alt="Profile 3" class="profile-picture">
                <div class="testimonial-text">
                    <p>"I've been using Tabib Health for a while now, and it has made a significant difference in my pharmacy workflow.
                        The drug dispensing tool saves time and reduces errors. Kudos to the team behind this brilliant app!"</p>
                    <p class="testimonial-author">- Mike Johnson</p>
                </div>
            </div>

            <div class="testimonial-card">
                <img src="images/profile4.jpeg" alt="Profile 4" class="profile-picture">
                <div class="testimonial-text">
                    <p>"I love how Tabib Health allows me to access my medical records and prescriptions on the go.
                        It's convenient and secure, giving me full control over my health information."</p>
                    <p class="testimonial-author">- Sarah Wilson</p>
                </div>
            </div>

            <div class="testimonial-card">
                <img src="images/profile5.jpeg" alt="Profile 5" class="profile-picture">
                <div class="testimonial-text">
                    <p>"Tabib Health has transformed the way I manage my health.
                        From scheduling doctor appointments to getting prescription reminders, it keeps everything in one place.
                        Highly recommended!"</p>
                    <p class="testimonial-author">- Alex Johnson</p>
                </div>
            </div>

            <!-- Add more testimonial cards here -->
        </div>
    </section>

    <!-- Contact Form and Map Section -->
    <section class="contact-map-section" id="contact">
        <div class="contact-and-location">
            <div class="contact-form">
                <h2>Contact Us</h2>
                <form action="#" method="post">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="4" required></textarea>

                    <button type="submit">Submit</button>
                </form>
            </div>
<!---->
<!--            <div class="location-details">-->
<!--                <h2>Our Location</h2>-->
<!--                <p>Address: 123 Main Street, City, Country</p>-->
<!--                <p>Email: info@example.com</p>-->
<!--                <p>Phone: +1 234 567 890</p>-->
<!--            </div>-->
        </div>
    </section>

    <footer class="footer">
        <div class="footer-logo">
            <img src="images/_Pngtree_medical_health_logo_4135858-removebg-preview.png" alt="Logo">
        </div>
        <div class="footer-links">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#testimonials">What our Users Say</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <div class="footer-location">
            <p>Address: 123 Strathmore University, Nairobi, Kenya</p>
            <p>Email: <a href="mailto:info@tabibhealth.com">info@tabibhealth.com</a></p>
            <p>Phone: <a href="tel:+254712345678">+254 (0) 712 345 678</a></p>
            <p>Copyright Steve Njino, Wendy Lagho</p>
            <p>All Rights Reserved.</p>
        </div>
    </footer>
</div>
<!-- Rest of our landing page content -->
<script src="js/index.js"></script>

</body>
</html>
