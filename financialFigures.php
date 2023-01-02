<?php
// getting all values from the HTML form
if (isset($_POST['submit'])) {
    $company_name = $_POST['company_name'];
    $overheads = $_POST['overheads'];
    $sales = $_POST['sales'];
    $cost_of_goods = $_POST['cost_of_goods'];
    $cash = $_POST['cash'];
    $debtors = $_POST['debtors'];
    $others = $_POST['others'];
    $furniture_and_fixtures = $_POST['furniture_and_fixtures'];
    $machinery_and_equipment = $_POST['machinery_and_equipment'];
    $land_and_buildings = $_POST['land_and_buildings'];
    $software = $_POST['software'];
    $creditors = $_POST['creditors'];
    $other_payables = $_POST['other_payables'];
    $long_term_loans = $_POST['long_term_loans'];
    $owners_funds = $_POST['owners_funds'];
}

// database details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "get_statements";

// creating a connection
$con = mysqli_connect($host, $username, $password, $dbname);

// to ensure that the connection is made
if (!$con) {
    die("Connection failed!" . mysqli_connect_error());
}

if (empty($company_name) || empty($overheads) || empty($sales) || empty($cost_of_goods) || empty($cash) && empty($debtors) || empty($others) || empty($furniture_and_fixtures) || empty($land_and_buildings) || empty($machinery_and_equipment) || empty($other_payables) || empty($long_term_loans) || empty($owners_funds) || empty($software) || empty($creditors)) {
    echo '<script> alert("Please enter all values"); window.location.href="businessForm.html";</script>';
} else {
    //select company id from company details
    $statement = "SELECT id from company_details WHERE company_name = '{$company_name}'";
    $result = mysqli_query($con, $statement);

    if (mysqli_num_rows($result) == 0) {
        echo '<script> alert("Please enter your company details first"); window.location.href="companyDetails.html";</script>';
    } else {
        session_start();
        while ($row = mysqli_fetch_array($result)) {
            $company_id = $row['id'];
            $_SESSION["company_id"] = $company_id;
            $sql = "INSERT INTO financial_figures (overheads, total_sales, cost_of_goods, cash, debtors, creditors, others, machinery_and_equipment, land_and_buildings, furniture_and_fixtures, software, other_payables, long_term_loans, owners_funds, company_id) VALUES ('$overheads', '$sales', '$cost_of_goods', '$cash', '$debtors', '$creditors', '$others', '$machinery_and_equipment', '$land_and_buildings','$furniture_and_fixtures', '$software', '$other_payables', '$long_term_loans', '$owners_funds', '$company_id')";

            // send query to the database to add values and confirm if successful
            $rs = mysqli_query($con, $sql);
            if ($rs) {
                echo '<script> alert("Successful data entry"); window.location.href="downloadForms.php";</script> ';
            }

            // close connection
            mysqli_close($con);
        }
    }
}
