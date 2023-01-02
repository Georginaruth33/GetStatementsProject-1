<?php
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "get_statements";
    
    // creating a connection
    $con = mysqli_connect($host, $username, $password, $dbname);
    $company_id = $_SESSION["company_id"]; 
    $query = "SELECT * FROM financial_figures where company_id = '$company_id'";

    $result = mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Get Statements</title>
</head>

<body>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Company Name</th>
                <th scope="col">Overheads</th>
                <th scope="col">Total Sales</th>
                <th scope="col">Cost of Goods</th>
                <th scope="col">Cash</th>
                <th scope="col">Debtors</th>
                <th scope="col">Creditors</th>
                <th scope="col">Others</th>
                <th scope="col">Machinery and Equipment</th>
                <th scope="col">Land and Buildings</th>
                <th scope="col">Furniture and Fixtures</th>
                <th scope="col">Software</th>
                <th scope="col">Other payables</th>
                <th scope="col">Long term loans</th>
                <th scope="col">Owners funds</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($rows=mysqli_fetch_array($result)){
            ?>
            <tr>
                <th scope="row"><?php echo $rows['company_id'] ?></th>
                <td><?php echo $rows['overheads'] ?></td>
                <td><?php echo $rows['total_sales'] ?></td>
                <td><?php echo $rows['cost_of_goods'] ?></td>
                <td><?php echo $rows['cash'] ?></td>
                <td><?php echo $rows['debtors'] ?></td>
                <td><?php echo $rows['creditors'] ?></td>
                <td><?php echo $rows['others'] ?></td>
                <td><?php echo $rows['machinery_and_equipment'] ?></td>
                <td><?php echo $rows['land_and_buildings'] ?></td>
                <td><?php echo $rows['furniture_and_fixtures'] ?></td>
                <td><?php echo $rows['software'] ?></td>
                <td><?php echo $rows['other_payables'] ?></td>
                <td><?php echo $rows['long_term_loans'] ?></td>
                <td><?php echo $rows['owners_funds'] ?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</body>

</html>