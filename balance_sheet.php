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
    $total_non_current_assets = $row['machinery_and_equipment'] + $row['land_and_buildings'] + $row['furniture_and_fixtures']+$row['software'];
    $total_current_liabilities = $row['creditors'] + $row['other_payables'];
    $total_non_current_liabilities = $row['long_term_loans'];
    $retained_earnings = $row['overheads']+($row['total_sales']-$row['cost_of_goods']);
    $total_shareholders_equity = $row['owners_funds'] - $retained_earnings;
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
                            <th>Current Assets <span class="description">Cash</span><span class="description">Debtors</span><span class="description">Others</span></th>
                        <tr class="data-total">
                            <th>Total Current Assets</th>
                            <td class="current"><?php echo $total_current_assets ?></td>
                        </tr>
                        <tr class="data">
                            <th>Non Current Assets <span class="description">Machinery and Equipment</span><span class="description">Land and Building</span><span class="description">Furniture and Fixtures</span><span class="description">Software</span></th>
                        <tr class="data-total">
                            <th>Total Non Current Assets</th>
                            <td class="current"><?php echo $total_non_current_assets ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Assets</th>
                            <td class="current"><?php echo $total_current_assets+$total_non_current_assets?></td>
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
                            <th>Current liabilities <span class="description">Creditors</span><span class="description">Other Payables</span></th>
                        </tr>
                        <tr class="total">
                            <th>Total Current liaibilities</th>
                            <td class="current"><?php echo $total_current_liabilities ?></td>
                        </tr>
                        <tr class="data">
                            <th>Non current liabilities <span class="description">Long term loans</span></th>
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
                            <th><span class="sr-only">2021</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data">
                            <th>Shareholders equity<span class="description">Owners funds</span><span class="description">Retained Earnings</span></th>
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
    </main>
</body>

</html>