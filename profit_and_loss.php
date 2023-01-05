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

    $profit_before_tax = ($row['total_sales'] - $row['cost_of_goods']) - $row['overheads'];
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
                    <span>Profit and Loss Statement</span>
                    <span><?php echo $company_name ?></span>
                </span>
            </h1>
            <div class="table-wrap">
                <table>
                    <tbody>
                        <tr class="data">
                            <th>Income</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Sales
                            </th>
                            <td class="current"><?php echo $row['total_sales'] ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Sales</th>
                            <td class="current"><?php echo $row['total_sales'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th>Cost of Goods Sold</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Cost of Goods
                            </th>
                            <td class="current"><?php echo $row['cost_of_goods'] ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Cost of Goods</th>
                            <td class="current"><?php echo $row['cost_of_goods'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th class="description">
                                Gross Profit
                            </th>
                            <td class="current"><?php echo $row['total_sales'] - $row['cost_of_goods'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th>Admin Costs</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Overheads
                            </th>
                            <td class="current"><?php echo $row['overheads'] ?></td>
                        </tr>
                        <tr class="total">
                            <th>Total Admin Costs</th>
                            <td class="current"><?php echo $row['overheads'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th class="description">Profit before tax</th>
                            <td class="current"><?php echo $profit_before_tax ?></td>
                        </tr>
                        <tr class="data">
                            <th class="description">Tax Expences</th>
                            <td class="current">0</td>
                        </tr>
                        <tr class="data">
                            <th class="description">Profit after tax</th>
                            <td class="current"><?php echo $profit_before_tax ?></td>
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