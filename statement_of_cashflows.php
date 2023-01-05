<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
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

    $statement = "SELECT * from financial_figures WHERE company_id = '$company_id' and id = '$id'";
    $rs = mysqli_query($con, $statement);
    $row = mysqli_fetch_array($rs);

    $net_operating = $row['total_sales']-$row['overheads']-$row['debtors']-$row['cost_of_goods']+$row['creditors'];
    $net_investing = $row['machinery_and_equipment'] + $row['land_and_buildings'] + $row['furniture_and_fixtures'] + $row['software'];
    $net_financing = $row['other_payables'] + $row['long_term_loans'] + $row['owners_funds'];
}
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
                    <span>Statement of Cashflows</span>
                    <span><?php echo $company_name ?></span>
                </span>
            </h1>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th class="current">Cashflows from Operating Activities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data">
                            <th class="description">
                                Receipts from Income
                            </th>
                            <td class="current"><?php echo $row['total_sales'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Payments of Expences
                            </th>
                            <td class="current"><?php echo $row['overheads'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Funding to Debtors
                            </th>
                            <td class="current"><?php echo $row['debtors'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Stock Movement
                            </th>
                            <td class="current"><?php echo $row['cost_of_goods'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Funding from Creditors
                            </th>
                            <td class="current"><?php echo $row['creditors'] ?></td>
                        </tr>
                        <tr class="total">
                            <th>Net Cash from Operating Activities</th>
                            <td class="current"><?php echo $net_operating ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th class="current">Cashflows from Investing Activities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data">
                            <th class="description">
                                Payments for property, plant, and equipment
                            </th>
                            <td class="current"><?php echo $net_investing ?></td>
                        </tr>
                        <tr class="total">
                            <th>Net Cash from Investing Activities</th>
                            <td class="current"><?php echo $net_investing ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th class="current">Cashflows from Financing Activities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data">
                            <th class="description">
                                Increase in Short-term Debt
                            </th>
                            <td class="current"><?php echo $row['other_payables'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Increase in Long-term Debt
                            </th>
                            <td class="current"><?php echo $row['long_term_loans'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Proceeds from Owner(Equity)
                            </th>
                            <td class="current"><?php echo $row['owners_funds'] ?></td>
                        </tr>
                        <tr class="total">
                            <th>Net Cash from financing activities</th>
                            <td class="current"><?php echo $net_financing ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Net increase in cash
                            </th>
                            <td class="current"><?php echo $net_financing + $net_operating + (-$net_investing) ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Cash balance start of year
                            </th>
                            <td class="current">0</td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Cash balance end of year
                            </th>
                            <td class="current"><?php echo $net_financing + $net_operating + (-$net_investing) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <div>
            <button class="btn"><a href="generatePdf.php">Download</a></button>
        </div>
    </main>
</body>

</html>