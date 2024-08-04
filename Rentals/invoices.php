<?php

include 'config.php';
include ('admin\includes\header.php');
include ('admin\includes\navbar.php');
include ('admin\includes\scripts.php');

if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM payments where id= " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}

?>


<div class="container">
    <div class="row">
        <!-- FORM Panel -->

        <!-- Table Panel -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>List of Payment</b>
                    <span class="">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#exampleModalLong">
                            Add Payment
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">New Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" id="manage-payment">
                                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                                        <div id="msg"></div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="" class="control-label">Tenant</label>
                                                <select name="tenant_id" id="tenant_id" class="custom-select select2">
                                                    <option value=""></option>
                                                    <?php
                                                    $tenant = $conn->query("SELECT *,concat(lname,', ',fname) as name FROM tenant where status = 1 order by name asc");
                                                    while ($row = $tenant->fetch_assoc()):
                                                        ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php echo isset($tenant_id) && $tenant_id == $row['id'] ? 'selected' : '' ?>>
                                                            <?php echo ucwords($row['name']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="form-group" id="details">

                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label">Invoice: </label>
                                                <input type="text" class="form-control" name="invoice"
                                                    value="<?php echo isset($invoice) ? $invoice : '' ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label">Amount Paid: </label>
                                                <input type="number" class="form-control text-right" step="any"
                                                    name="amount" value="<?php echo isset($amount) ? $amount : '' ?>">
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" id="manage-payment">Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div id="details_clone" style="display: none">
                            <div class='d'>
                                <large><b>Details</b></large>
                                <hr>
                                <p>Tenant: <b class="tname"></b></p>
                                <p>Monthly Rental Rate: <b class="price"></b></p>
                                <p>Outstanding Balance: <b class="outstanding"></b></p>
                                <p>Total Paid: <b class="total_paid"></b></p>
                                <p>Rent Started: <b class='rent_started'></b></p>
                                <p>Payable Months: <b class="payable_months"></b></p>
                                <hr>
                            </div>
                        </div>
                    </span>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="">Date</th>
                                        <th class="">Tenant</th>
                                        <th class="">Invoice</th>
                                        <th class="">Amount</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $invoices = $conn->query("SELECT p.*,concat(t.lname,', ',t.fname) as name FROM payments p inner join tenant t on t.id = p.tenant_id where t.status = 1 order by date(p.date_created) desc ");
                                    while ($row = $invoices->fetch_assoc()):

                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $i++ ?>
                                            </td>
                                            <td>
                                                <?php echo date('M d, Y', strtotime($row['date_created'])) ?>
                                            </td>
                                            <td class="">
                                                <p> <b>
                                                        <?php echo ucwords($row['name']) ?>
                                                    </b></p>
                                            </td>
                                            <td class="">
                                                <p> <b>
                                                        <?php echo ucwords($row['invoice']) ?>
                                                    </b></p>
                                            </td>
                                            <td class="text-right">
                                                <p> <b>
                                                        <?php echo number_format($row['amount'], 2) ?>
                                                    </b></p>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary view_payment" type="button"
                                                    data-id="<?php echo $row['id'] ?>">View</button>
                                                <button class="btn btn-sm btn-outline-primary edit_tenant" type="button"
                                                    data-id="<?php echo $row['id'] ?>">Edit</button>
                                                <button class="btn btn-sm btn-outline-danger delete_tenant" type="button"
                                                    data-id="<?php echo $row['id'] ?>">Delete</button>
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
<script>
    $(document).ready(function () {
        if ('<?php echo isset($id) ? 1 : 0 ?>' == 1)
            $('#tenant_id').trigger('change')
    })
    // $('.select2').select2({
    // placeholder:"Please Select Here",
    //width:"100%"
    // })
    $('#tenant_id').change(function () {
        if ($(this).val() <= 0)
            return false;

        // start_load()
        $.ajax({
            url: 'ajax.php?action=get_tdetails',
            method: 'POST',
            data: { id: $(this).val(), pid: '<?php echo isset($id) ? $id : '' ?>' },
            success: function (resp) {
                if (resp) {
                    resp = JSON.parse(resp)
                    var details = $('#details_clone .d').clone()
                    details.find('.tname').text(resp.name)
                    details.find('.price').text(resp.price)
                    details.find('.outstanding').text(resp.outstanding)
                    details.find('.total_paid').text(resp.paid)
                    details.find('.rent_started').text(resp.rent_started)
                    details.find('.payable_months').text(resp.months)
                    console.log(details.html())
                    $('#details').html(details)
                }
            },
            complete: function () {
                //end_load()
            }
        })
    })
    $('#manage-payment').submit(function (e) {
        e.preventDefault()
        //start_load()
        $('#msg').html('')
        $.ajax({
            url: 'ajax.php?action=save_payment',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    //alert_toast("Data successfully saved.",'success')
                    setTimeout(function () {
                        location.reload()
                    }, 1000)
                }
            }
        })
    })
</script>