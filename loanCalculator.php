<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost"; // Adjust as necessary
$username = "root"; // Replace with your database username
$password = "MySql_987"; // Replace with your database password
$dbname = "loancalculator"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$monthlyInstallment = null;
$annualInstallment = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['calculate'])) {
        $loanAmount = floatval($_POST['loanAmount']);
        $loanReason = $_POST['loanReason'];
        $tenure = intval($_POST['tenure']);

        // Validate tenure
        if ($tenure <= 0) {
            echo "<script>alert('Error: Tenure must be greater than 0.');</script>";
            return;
        }

        // Get accurate interest rate based on loan reason
        function getAccurateInterestRate($loanReason) {
            switch ($loanReason) {
                case 'Home Loan':
                    return 0.75;
                case 'Car Loan':
                    return 0.85;
                case 'Education Loan':
                    return 0.65;
                case 'Personal Loan':
                    return 1.00;
                default:
                    return 0;
            }
        }

        // Calculate monthly installment
        function calculateMonthlyInstallment($loanAmount, $interestRate, $tenure) {
            $rate = $interestRate / 1200;
            if ($rate == 0) {
                return $loanAmount / $tenure;
            } else {
                $numerator = $rate * $loanAmount;
                $denominator = 1 - pow(1 + $rate, -$tenure);
                return $numerator / $denominator;
            }
        }

        // Get interest rate
        $interestRate = getAccurateInterestRate($loanReason);

        // Calculate installments
        $monthlyInstallment = calculateMonthlyInstallment($loanAmount, $interestRate, $tenure);
        $annualInstallment = $monthlyInstallment * 12;

        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO loans (loan_amount, loan_reason, tenure, monthly_installment, annual_installment) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("dsddd", $loanAmount, $loanReason, $tenure, $monthlyInstallment, $annualInstallment);
        $stmt->execute();
        $stmt->close();
    }

    // Handle the show data action
    if (isset($_POST['showData'])) {
        $selectedReason = $_POST['selectedReason'];
        $query = "SELECT * FROM loans WHERE loan_reason = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $selectedReason);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Loan Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="loanCalculator.css">
    <style>
        .data-box {
            min-height: 400px; /* Set a minimum height for the box */
            overflow-y: auto; /* Allow scrolling if content exceeds */
        }
        .table th, .table td {
            white-space: nowrap; /* Prevent text wrapping in table cells */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8"> <!-- 2/3 of the space -->
                <h1 class="text-center text-dark font-weight-bold">Loan Calculator</h1>
                <form method="POST" action="loanCalculator.php" class="mt-4 p-4 border rounded shadow-sm bg-white">
                    <div class="form-group">
                        <label for="loanAmount">Loan Amount</label>
                        <input type="number" id="loanAmount" name="loanAmount" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="loanReason">Loan Reason</label>
                        <select id="loanReason" name="loanReason" class="form-control" required>
                            <option value="Home Loan">Home Loan</option>
                            <option value="Car Loan">Car Loan</option>
                            <option value="Education Loan">Education Loan</option>
                            <option value="Personal Loan">Personal Loan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tenure">Tenure (Months)</label>
                        <input type="number" id="tenure" name="tenure" class="form-control" required>
                    </div>
                    <button type="submit" name="calculate" class="btn btn-dark btn-block">Calculate</button>
                </form>

                <?php if ($monthlyInstallment !== null): ?>
                <div class="result mt-4 p-4 rounded border shadow">
                    <h3 class="text-center text-success">Results</h3>
                    <p class="text-center">Monthly Installment: <strong><?php echo number_format($monthlyInstallment, 2); ?> ₹</strong></p>
                    <p class="text-center">Annual Installment: <strong><?php echo number_format($annualInstallment, 2); ?> ₹</strong></p>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4"> <!-- 1/3 of the space -->
                <form method="POST" action="loanCalculator.php" class="mt-4 p-4 border rounded shadow-sm bg-white">
                    <div class="form-group">
                        <label for="selectedReason">Select Loan Reason to View Data</label>
                        <select id="selectedReason" name="selectedReason" class="form-control">
                            <option value="Home Loan">Home Loan</option>
                            <option value="Car Loan">Car Loan</option>
                            <option value="Education Loan">Education Loan</option>
                            <option value="Personal Loan">Personal Loan</option>
                        </select>
                    </div>
                    <button type="submit" name="showData" class="btn btn-dark btn-block">Show Data</button>
                </form>

                <div class="data-box mt-4 p-4 rounded border shadow">
                    <?php if (isset($result) && $result->num_rows > 0): ?>
                    <h3 class="text-center">Stored Data</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Loan Amount</th>
                                <th>Loan Reason</th>
                                <th>Tenure</th>
                                <th>Monthly Installment</th>
                                <th>Annual Installment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo number_format($row['loan_amount'], 2); ?> Rs</td>
                                <td><?php echo $row['loan_reason']; ?></td>
                                <td><?php echo $row['tenure']; ?></td>
                                <td><?php echo number_format($row['monthly_installment'], 2); ?> Rs</td>
                                <td><?php echo number_format($row['annual_installment'], 2); ?> Rs</td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <h5 class="text-center">No data available.</h5>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
