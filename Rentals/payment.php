<?php

include 'config.php';
include ('admin\includes\header.php');
include ('admin\includes\navbar.php');
include ('admin\includes\scripts.php');

?>


<div class="container">
    <div class="row">
        <!-- FORM Panel -->

        <!-- Table Panel -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>List of Payment</b>
                    
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="">Tenant</th>
                                        <th class="">House No</th>
                                        <th class="">Outstanding Balance</th>
                                        <th class="">Last Payment</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $tenant = $conn->query("SELECT t.*,concat(t.lname,', ',t.fname) as name,h.house_no,h.price FROM tenant t inner join houses h on h.id = t.house_id where t.status = 1 order by h.house_no desc ");
                                    while ($row = $tenant->fetch_assoc()):
                                        $months = abs(strtotime(date('Y-m-d') . " 23:59:59") - strtotime($row['date_in'] . " 23:59:59"));
                                        $months = floor(($months) / (30 * 60 * 60 * 24));
                                        $months = max(1, $months);

                                        $payable = $row['price'] * $months;
                                        $paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =" . $row['id']);
                                        $last_payment = $conn->query("SELECT * FROM payments where tenant_id =" . $row['id'] . " order by unix_timestamp(date_created) desc limit 1");
                                        $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
                                        $last_payment = $last_payment->num_rows > 0 ? date("Y M, d", strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
                                        $outstanding = $payable - $paid;

                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $i++ ?>
                                            </td>
                                            <td class="">
                                                <p> <b>
                                                        <?php echo ucwords($row['name']) ?>
                                                    </b></p>
                                            </td>
                                            <td class="">
                                                <p> <b>
                                                        <?php echo $row['house_no'] ?>
                                                    </b></p>
                                            </td>
                                            <td class="text-right">
                                                <p> <b>
                                                        <?php echo number_format($outstanding, 2) ?>
                                                    </b></p>
                                            </td>
                                            <td class="">
                                                <p><b>
                                                        <?php echo $last_payment ?>
                                                    </b></p>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary view_payment" type="button"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    onclick="redirectToView()">View</button>
                                                <script>
                                                    function redirectToView() {
                                                        // Get the ID from the button's data attribute
                                                        var id = document.querySelector('.view_payment').getAttribute('data-id');

                                                        // Redirect to view_payment.php with the ID as a query parameter
                                                        window.location.href = 'view_payment.php?id=' + id;
                                                    }
                                                </script>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- Table Panel -->
    </div>
</div>