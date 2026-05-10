<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UITS | Industry Attachment Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #003366;
            --accent: #FFC600;
            --light-bg: #f4f7f9;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--light-bg);
            color: #333;
            line-height: 1.6;
        }

        /* Navigation */
        nav {
            background: var(--white);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo h1 {
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 700;
        }

        .logo span {
            color: var(--accent);
        }

        .nav-links a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 500;
            margin-left: 25px;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.8)), 
                        url('https://uits.edu.bd/wp-content/uploads/2022/03/UITS-Permanent-Campus.jpg');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--white);
            padding: 0 20px;
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.1rem;
            max-width: 700px;
            opacity: 0.9;
        }

        /* Portal Selection Cards */
        .portal-section {
            padding: 80px 5%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: -100px; /* Overlap hero */
        }

        .card {
            background: var(--white);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: 0.3s;
            border-bottom: 5px solid transparent;
        }

        .card:hover {
            transform: translateY(-10px);
            border-color: var(--accent);
        }

        .card i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .card h3 {
            margin-bottom: 15px;
            color: var(--primary);
        }

        .card .btn {
            display: inline-block;
            padding: 10px 25px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: 600;
            transition: 0.3s;
        }

        .card .btn:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* Footer / Contact Us */
        footer {
            background: #001a33;
            color: white;
            padding: 60px 5% 20px 5%;
            margin-top: 50px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-about h3, .footer-contact h3 {
            color: var(--accent);
            margin-bottom: 20px;
        }

        .footer-contact ul {
            list-style: none;
        }

        .footer-contact li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .footer-contact i {
            color: var(--accent);
            margin-right: 15px;
            margin-top: 5px;
        }

        .copyright {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 0.85rem;
            color: rgba(255,255,255,0.5);
        }

        @media (max-width: 768px) {
            .hero h2 { font-size: 1.8rem; }
            .grid { margin-top: 20px; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">
            <h1>UITS<span>.Portal</span></h1>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="#contact">Contact Us</a>
        </div>
    </nav>

    <header class="hero">
        <h2>Industrial Attachment Management</h2>
        <p>Connecting students, lecturers, and industrial trainers for a seamless internship and placement experience.</p>
    </header>

    <section class="portal-section">
        <div class="grid">
            <div class="card">
                <i class="fa fa-user-graduate"></i>
                <h3>Students</h3>
                <p>Register your attachment details and manage your placement profile.</p>
                <a href="students/studentregistration.php" class="btn">Register Now</a>
            </div>

            <div class="card">
                <i class="fa fa-chalkboard-teacher"></i>
                <h3>Lecturers</h3>
                <p>Monitor student progress and coordinate with industrial supervisors.</p>
                <a href="lecturers/lecturerregistration.php" class="btn">Register Now</a>
            </div>

            <div class="card">
                <i class="fa fa-user-tie"></i>
                <h3>Trainers</h3>
                <p>Provide feedback and verify student attendance at your organization.</p>
                <a href="trainers/trainerregistration.php" class="btn">Register Now</a>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="footer-grid">
            <div class="footer-about">
                <h3>About UITS</h3>
                <p>The University of Information Technology & Sciences (UITS) is dedicated to providing high-quality IT-based education to produce skilled professionals for the global market.</p>
            </div>

            <div class="footer-contact">
                <h3>Contact Us</h3>
                <ul>
                    <li>
                        <i class="fa fa-map-marker-alt"></i>
                        <span>Holding 153 (Old 190), Road 05, Baridhara J Block, Vatara, Dhaka-1212.</span>
                    </li>
                    <li>
                        <i class="fa fa-phone"></i>
                        09678008487 (Office)
                    </li>
                    <li>
                        <i class="fa fa-envelope"></i>
                        info@uits.edu.bd
                    </li>
                </ul>
            </div>

            <div class="footer-contact">
                <h3>Admission Help</h3>
                <ul>
                    <li><i class="fa fa-mobile-alt"></i> 01939915209</li>
                    <li><i class="fa fa-mobile-alt"></i> 01713487709</li>
                    <li><i class="fa fa-mobile-alt"></i> 01844043870</li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            &copy; 2026 University of Information Technology & Sciences. All Rights Reserved.
        </div>
    </footer>

</body>
</html>