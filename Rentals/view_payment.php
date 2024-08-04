<?php
include 'config.php';
include 'admin/includes/header.php';
include 'admin/includes/navbar.php';
include 'admin/includes/scripts.php';
?>

<?php
$tenant = $conn->query("SELECT t.*, CONCAT(t.lname, ', ', t.fname) as name, h.house_no, h.price FROM tenant t INNER JOIN houses h ON h.id = t.house_id WHERE t.id = {$_GET['id']} ");
foreach ($tenant->fetch_array() as $k => $v) {
    if (!is_numeric($k)) {
        $$k = $v;
    }
}
$months = abs(strtotime(date('Y-m-d') . " 23:59:59") - strtotime($date_in . " 23:59:59"));
$months = floor(($months) / (30 * 60 * 60 * 24));
$payable = $price * $months;
$paid = $conn->query("SELECT SUM(amount) as paid FROM payments WHERE tenant_id =" . $_GET['id']);
$last_payment = $conn->query("SELECT * FROM payments where tenant_id =" . $row['id'] . " order by unix_timestamp(date_created) desc limit 1");
$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
$last_payment = $last_payment->num_rows > 0 ? date("M d, Y", strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
$outstanding = $payable - $paid;
?>
<section>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <ol class="breadcrumb" style="background-color: transparent;">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="view_payment.php">View Payments</a></li>
        </ol>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="details">
                    <large><b>Details</b></large>
                    <hr>
                    <p>Tenant: <b>
                            <?php echo ucwords($name) ?>
                        </b></p>
                    <p>Monthly Rental Rate: <b>
                            <?php echo number_format($price, 2) ?>
                        </b></p>
                    <p>Outstanding Balance: <b>
                            <?php echo number_format($outstanding, 2) ?>
                        </b></p>
                    <p>Total Paid: <b>
                            <?php echo number_format($paid, 2) ?>
                        </b></p>
                    <p>Rent Started: <b>
                            <?php echo date("M d, Y", strtotime($date_in)) ?>
                        </b></p>
                    <p>Payable Months: <b>
                            <?php echo $months ?>
                        </b></p>
                </div>
            </div>
            <div class="col-md-8">
                <large><b>Payment List</b></large>
                <hr>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $payments = $conn->query("SELECT * FROM payments WHERE tenant_id = $id");
                            if ($payments->num_rows > 0):
                                while ($row = $payments->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo date("M d, Y", strtotime($row['date_created'])) ?>
                                        </td>
                                        <td>
                                            <?php echo $row['invoice'] ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($row['amount'], 2) ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    #details p {
        margin: unset;
        padding: unset;
        line-height: 1.3em;
    }

    td,
    th {
        padding: 3px !important;
    }
</style>