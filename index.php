<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Calculator - Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        /* Hero Section */
        .hero-section {
            position: relative;
            background-image: url('https://source.unsplash.com/1600x900/?loan,money'); /* Ensure the link works, or use a local image */
            background-size: cover;
            background-position: center;
            height: 80vh;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
        }
        /* Add a dark overlay to improve text readability */
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
            z-index: 1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-section h1 {
            font-size: 4rem;
            font-weight: bold;
            color: #fff;
        }
        .quote {
            font-size: 1.5rem;
            margin-top: 20px;
            color: #f8f9fa;
        }
        .info-section {
            padding: 40px 20px;
            text-align: center;
        }
        .info-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .info-box {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .info-box h3 {
            font-size: 1.5rem;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Loan Calculator</a>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="loanCalculator.php">Calculator</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Welcome to Loan Calculator</h1>
            <p class="quote">"Get the best loan plan, with full transparency!"</p>
        </div>
    </section>

    <!-- Info Section -->
    <section class="info-section">
        <div class="container">
            <h2>Types of Loans We Offer</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <h3>Home Loan</h3>
                        <p>Need help with buying your dream home? Our home loan options offer low-interest rates and flexible terms.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <h3>Car Loan</h3>
                        <p>Drive your dream car sooner with our competitive car loan plans, designed to suit your financial needs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <h3>Education Loan</h3>
                        <p>Invest in your future with an education loan that offers support for tuition fees, living expenses, and more.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section class="info-section">
        <div class="container">
            <h2>How Our Calculator Works</h2>
            <div class="info-box">
                <p>Our loan calculator helps you understand your potential monthly and annual payments based on your loan amount, tenure, and type of loan. Simply enter the necessary details, and we'll calculate an accurate estimation of your financial commitment.</p>
            </div>
            <a href="loanCalculator.php" class="btn btn-dark mt-4">Try the Calculator</a>
        </div>
    </section>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Loan Calculator. All rights reserved.</p>
    </div>
</body>
</html>
