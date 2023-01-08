<?php

namespace Dompdf;

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
    $retained_earnings = ($row['total_sales'] - $row['cost_of_goods']) - $row['overheads'];
    $total_shareholders_equity = $row['owners_funds'] + $retained_earnings;
}
?>
<?php
$html = '
<style>
@import url(\'https://fonts.googleapis.com/css?family=Nunito:400,900|Montserrat|Roboto\');

html {
	box-sizing: border-box;
}

body {
    font-family: \'Roboto\', sans-serif;
	color: #0a0a23;
    background: linear-gradient(to right, #3FB6A8, #7ED386);
}

h1 {
	max-width: 37.25rem;
	margin: 0 auto;
	padding: 1.5rem 1.25rem 1.5rem;
    font-family: \'Montserrat\', sans-serif;
    color: black;
    font-size: 2em;
}

h1 .flex {
	display: flex;
	flex-direction: column-reverse;
	gap: 1rem;
	font-size: 0.7em;
}
th.description{
	font-weight: normal;
	font-style: italic;
	display: block;
	padding: 1rem 0 0.75rem;
	margin-right: -13.5rem;
}

section {
	max-width: 40rem;
	margin: 0 auto;
	border: 1px solid black;
}

.table-wrap {
	padding: 0 0.75rem 1.5rem 0.75rem;
}

table {
	border-collapse: collapse;
	border: 0;
	width: 100%;
	position: relative;
}

tbody td {
	width: 100vw;
	min-width: 4rem;
	max-width: 4rem;
}

tbody th {
	width: cal(100% - 12rem);
}
tr.total{
	color:black;
}

tr.total,tr.data-total {
	border-bottom: 4px double #0a0a23;
	font-weight: bold;
}
tr.total,tr.data-total th {
	text-align: left;
	padding: 0.5rem 0 0.25rem 0.5rem;
}

tr.total td,tr.data-total td {
	text-align: right;
	padding: 0 0.25rem;
}

tr.total td:last-of-type,tr.data-total td:last-of-type {
	padding-right: 0.5rem;
}

tr.total:hover{
	background-color: #99c9ff;
}

td.current {
	font-style: italic;
}

tr th.name {
	color: #000 !important;
	font-size: 1em !important;
	font-weight: bold !important;
}

tr.data th {
	text-align: left;
	padding-left: 0.5rem;
}

tr.data th .description {
	display: block;
	font-weight: normal;
	font-style: italic;
	padding: 1rem 0 0.75rem;
	margin-right: -13.5rem;
}

tr.data td {
	vertical-align: top;
	padding: 0.3rem 0.25rem 0;
	text-align: right;
}

tr.data td:last-of-type {
	padding-right: 0.5rem;
}
}
</style>
<body>
    <main>
        <section>
            <h1>
                <span class="flex">
                    <!-- This seems like a more natural order for screen readers and we can use flex to reverse them in the layout -->
                    <span>' . $company_name . '</span><br>
                    <span>Balance Sheet</span><br>
                    <span>For period ending ' . $row['end_acc'] . '</span><br>
                    <span>' . $row['currency'] . '</span>
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
                            <td class="current">' . $row['cash'] . '</td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Debtors
                            </th>
                            <td class="current">' . $row['debtors'] . '</td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Others
                            </th>
                            <td class="current">' . $row['others'] . '</td>
                        </tr>
                        <tr class="data-total">
                            <th>Total Current Assets</th>
                            <td class="current">' . $total_current_assets . '</td>
                        </tr>
                        <tr class="data">
                            <th>Non Current Assets</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Machinery and Equipment
                            </th>
                            <td class="current">' . $row['machinery_and_equipment'] . '</td>
                        </tr><tr class="data">
                            <th class="description">
                                Land and Buildings
                            </th>
                            <td class="current">' . $row['land_and_buildings'] . '</td>
                        </tr><tr class="data">
                            <th class="description">
                                Furniture and Fixtures
                            </th>
                            <td class="current">' . $row['furniture_and_fixtures'] . '</td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Software
                            </th>
                            <td class="current">' . $row['software'] . '</td>
                        </tr>
                        <tr class="data-total">
                            <th>Total Non Current Assets</th>
                            <td class="current">' . $total_non_current_assets . '</td>
                        </tr>
                        <tr class="total">
                            <th>Total Assets</th>
                            <td class="current">' . $total_current_assets + $total_non_current_assets . '</td>
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
                            <td class="current">' . $row['creditors'] . '</td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Other Payables
                            </th>
                            <td class="current">' . $row['other_payables'] . '</td>
                        </tr>
                        <tr class="total">
                            <th>Total Current liaibilities</th>
                            <td class="current">' . $total_current_liabilities . '</td>
                        </tr>
                        <tr class="data">
                            <th>Non current liabilities</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Long-term Loans
                            </th>
                            <td class="current">' . $row['long_term_loans'] . '</td>
                        </tr>
                        <tr class="total">
                            <th>Total Non Current liaibilities</th>
                            <td class="current">' . $total_non_current_liabilities . '</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th>Shareholders equity</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Owners Funds
                            </th>
                            <td class="current">' . $row['owners_funds'] . '</td>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Retained Earnings
                            </th>
                            <td class="current">' . $retained_earnings . '</td>
                        </tr>
                        <tr class="total">
                            <th>Total Shareholders equity</th>
                            <td class="current">' . $total_shareholders_equity . '</td>
                        </tr>
                        <tr class="total">
                            <th>Total Liabilities</th>
                            <td class="current">' . $total_shareholders_equity + $total_current_liabilities + $total_non_current_liabilities . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>'
?>
<?php

require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//how-to-convert-dynamic-php-file-to-pdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
$dompdf->render();

ob_end_clean();
// displays the generated PDF in a browser
$dompdf->stream("balance_sheet_for_" . $row['end_acc'] . ".pdf", array("Attachment" => false));

// Outputs the generated PDF to Browser downloads directly
//  $dompdf->stream();
exit(0);

?>

</html>