<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | UITS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #003366;
            --accent: #FFC600;
            --dark-blue: #001a33;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Deeper, more serious gradient for Admin portal */
            background: radial-gradient(circle at center, #1a2a6c, #b21f1f, #fdbb2d);
            background: linear-gradient(135deg, var(--dark-blue) 0%, #003366 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Glassmorphism Admin Card */
        .admin-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 50px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .admin-icon {
            width: 80px;
            height: 80px;
            background: var(--accent);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            font-size: 2.2rem;
            box-shadow: 0 10px 20px rgba(255, 198, 0, 0.2);
        }

        .admin-card h2 {
            color: var(--white);
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .admin-card p.subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            margin-bottom: 35px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Input Layout */
        .input-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }

        .input-group label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.8rem;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            bottom: 13px;
            color: var(--accent);
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: var(--white);
            outline: none;
            transition: 0.3s;
            font-size: 1rem;
        }

        .input-group input:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.15);
        }

        /* Admin Button */
        .btn-admin {
            width: 100%;
            padding: 15px;
            background: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(255, 198, 0, 0.3);
            background: #f2bc00;
        }

        .home-link {
            display: inline-block;
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .home-link:hover {
            color: var(--accent);
        }

    </style>
</head>
<body>

    <div class="admin-card">
        <div class="admin-icon">
            <i class="fa fa-user-shield"></i>
        </div>
        <h2>Admin Login</h2>
        <p class="subtitle">Secure Control Panel</p>

        <form method="post" id="adminlogin" action="login.php" onSubmit="return validateForm()">
            <div class="input-group">
                <label>Username</label>
                <i class="fa fa-user"></i>
                <input type="text" name="username" id="username" placeholder="Admin Username">
            </div>

            <div class="input-group">
                <label>Password</label>
                <i class="fa fa-key"></i>
                <input type="password" name="password" id="password" placeholder="••••••••">
            </div>

            <button type="submit