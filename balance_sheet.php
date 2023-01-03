<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$dbname = "get_statements";

$company_id = $_SESSION["company_id"];

// creating a connection
$con = mysqli_connect($host, $username, $password, $dbname);

$query = "SELECT company_name from company_details WHERE id = '$company_id'";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $company_name = $row[0];
}

$statement = "SELECT * from financial_figures WHERE company_id = '$company_id'";
$rs = mysqli_query($con, $statement);
$row = mysqli_fetch_array($rs);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="statements.css">
    <title>Get Statements</title>
</head>

<body>
    <div class="statements">
        <a href="businessForm.html">Enter financial details</a>
        <a href="downloadForms.php">Back</a>
        <a href="logout.php">Logout</a>
    </div>
    <main>
        <section>
            <h1>
                <!-- Can't put flex on the <h1> or some screen readers won't announce both strings. -->
                <span class="flex">
                    <!-- This seems like a more natural order for screen readers and we can use flex to reverse them in the layout -->

                    <span><?php echo $row['currency'] ?></span>
                    <span>For period ending <?php echo $row['end_acc'] ?></span>
                    <span>Balance Sheet</span>
                    <span><?php echo $company_name ?></span>
                </span>
            </h1>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th class="current"><span class="sr-only">2021</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="total">
                            <th>Total Assets</th>
                            <td class="current"><?php echo $row['total_sales'] + $row['cash'] + $row['debtors'] + $row['others'] + $row['machinery_and_equipment'] + $row['land_and_buildings'] + $row['furniture_and_fixtures'] + $row['software'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">Current liabilities <span class="description">Creditors</span><span class="description">Other liablities</span></th>
                        </tr>
                        <tr class="total">
                            <th>Total current liaibilities</th>
                            <td class="current"><?php ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th><span class="sr-only">2021</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data">
                            <th>Loans <span class="description">The outstanding balance on our startup loan.</span></th>
                            <td class="current">$0</td>
                        </tr>
                        <tr class="data">
                            <th>Expenses <span class="description">Annual anticipated expenses, such as payroll.</span></th>
                            <td class="current">$400</td>
                        </tr>
                        <tr class="data">
                            <th>Credit <span class="description">The outstanding balance on our credit card.</span></th>
                            <td class="current">$75</td>
                        </tr>
                        <tr class="total">
                            <th>Total <span class="sr-only">Liabilities</span></th>
                            <td class="current">$500</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th><span class="sr-only">2021</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="total">
                            <th>Total <span class="sr-only">Net Worth</span></th>
                            <td class="current">$809</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>