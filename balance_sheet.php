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

    $total_current_assets = $row['cash'] + $row['debtors'] + $row['others'];
    $total_non_current_assets = $row['machinery_and_equipment'] + $row['land_and_buildings'] + $row['furniture_and_fixtures'] + $row['software'];
    $total_current_liabilities = $row['creditors'] + $row['other_payables'];
    $total_non_current_liabilities = $row['long_term_loans'];
    $retained_earnings = ($row['total_sales'] - $row['cost_of_goods'])-$row['overheads'];
    $total_shareholders_equity = $row['owners_funds'] + $retained_earnings;
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
                    <span>Balance Sheet</span>
                    <span><?php echo $company_name ?></span>
                </span>
            </h1>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th class="current">Assets</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data">
                            <th>Current Assets</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Cash
                            </th>
                            <td class="current"><?php echo $row['cash'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Debtors
                            </th>
                            <td class="current"><?php echo $row['debtors'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Others
                            </th>
                            <td class="current"><?php echo $row['others'] ?></td>
                        </tr>
                        <tr class="data-total">
                            <th>Total Current Assets</th>
                            <td class="current"><?php echo $total_current_assets ?></td>
                        </tr>
                        <tr class="data">
                            <th>Non Current Assets</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Machinery and Equipment
                            </th>
                            <td class="current"><?php echo $row['machinery_and_equipment'] ?></td>
                        </tr><tr class="data">
                            <th class="description">
                                Land and Buildings
                            </th>
                            <td class="current"><?php echo $row['land_and_buildings'] ?></td>
                        </tr><tr class="data">
                            <th class="description">
                                Furniture and Fixtures
                            </th>
                            <td class="current"><?php echo $row['furniture_and_fixtures'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Software
                            </th>
                            <td class="current"><?php echo $row['software'] ?></td>
                        </tr>
                        <tr class="data-total">
                            <th>Total Non Current Assets</th>
                            <td class="current"><?php echo $total_non_current_assets ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Assets</th>
                            <td class="current"><?php echo $total_current_assets + $total_non_current_assets ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th class="current">Liabilities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data">
                            <th>Current liabilities</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Creditors
                            </th>
                            <td class="current"><?php echo $row['creditors'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Other Payables
                            </th>
                            <td class="current"><?php echo $row['other_payables'] ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Current liaibilities</th>
                            <td class="current"><?php echo $total_current_liabilities ?></td>
                        </tr>
                        <tr class="data">
                            <th>Non current liabilities</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Long-term Loans
                            </th>
                            <td class="current"><?php echo $row['long_term_loans'] ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Non Current liaibilities</th>
                            <td class="current"><?php echo $total_non_current_liabilities ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th><span class="sr-only"></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data">
                            <th>Shareholders equity</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Owners Funds
                            </th>
                            <td class="current"><?php echo $row['owners_funds'] ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Retained Earnings
                            </th>
                            <td class="current"><?php echo $retained_earnings ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Shareholders equity</th>
                            <td class="current"><?php echo $total_shareholders_equity ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Liabilities</th>
                            <td class="current"><?php echo $total_shareholders_equity + $total_current_liabilities + $total_non_current_liabilities ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <div>
            <button class="btn">Download</button>
        </div>
    </main>
</body>

</html>