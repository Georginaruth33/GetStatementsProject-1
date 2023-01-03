<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$dbname = "get_statements";

$company_id = $_SESSION["company_id"];

// creating a connection
$con = mysqli_connect($host, $username, $password, $dbname);
$query = "SELECT * FROM financial_figures where company_id = '$company_id'";

$result = mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <title>Get Statements</title>
</head>

<body>
    <div class="statements">
        <a href="businessForm.html">Enter financial details</a>
        <a href="logout.php">Logout</a>
    </div>
    <div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Beginning of Accounting Period</th>
                    <th>End of accounting period</th>
                    <th scope="col">Profit and loss</th>
                    <th scope="col">Statement of cashflows</th>
                    <th scope="col">Balance sheet</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rows = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $rows['beginning_acc'] ?></td>
                        <td><?php echo $rows['end_acc'] ?></td>
                        <td><a href="profit_and_loss.php">View profit and loss statement</a></td>
                        <td><a href="statement_of_cashflows.php">view statement of cashflows</a></td>
                        <td><a href="balance_sheet.php">view balance sheet</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>