<?php

include 'config.php';
include ('admin\includes\header.php');
include ('admin\includes\navbar.php');
include ('admin\includes\scripts.php');

if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM tenant where id= " . $_GET['id']);
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
                    <b>List of Tenant</b>
                        <span class="">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#exampleModalLong">
                                Add tenant
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">New Tenant</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" id="manage-tenant">
                                        <div class="modal-body">
                                                <input type="hidden" name="id"
                                                    value="<?php echo isset($id) ? $id : '' ?>">
                                                <div class="row form-group">
                                                    <div class="col-md-4">
                                                        <label for="" class="control-label">Last Name</label>
                                                        <input type="text" class="form-control" name="lname"
                                                            value="<?php echo isset($lname) ? $lname : '' ?>" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="control-label">First Name</label>
                                                        <input type="text" class="form-control" name="fname"
                                                            value="<?php echo isset($fname) ? $fname : '' ?>" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="control-label">Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="<?php echo isset($email) ? $email : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">

                                                    <div class="col-md-4">
                                                        <label for="" class="control-label">Contact #</label>
                                                        <input type="text" class="form-control" name="contact"
                                                            value="<?php echo isset($contact) ? $contact : '' ?>"
                                                            required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="" class="control-label">House</label>
                                                        <select name="house_id" id="" class="custom-select select2">
                                                            <option value=""></option>
                                                            <?php
                                                            $house = $conn->query("SELECT * FROM houses where id not in (SELECT house_id from tenant where status = 1) " . (isset($house_id) ? " or id = $house_id" : "") . " ");
                                                            while ($row = $house->fetch_assoc()):
                                                                ?>
                                                                <option value="<?php echo $row['id'] ?>" <?php echo isset($house_id) && $house_id == $row['id'] ? 'selected' : '' ?>>
                                                                    <?php echo $row['house_no'] ?>
                                                                </option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="" class="control-label">Registration Date</label>
                                                        <input type="date" class="form-control" name="date_in"
                                                            value="<?php echo isset($date_in) ? date("Y-m-d", strtotime($date_in)) : '' ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" id="manage-tenant">Save </button>
                                            </div>
                                        </div>
                                            </form>

                                            
                                    </div>
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
                                        <th>Name</th>
                                        <th>House Rented</th>
                                        <th>Monthly Rate</th>
                                        <th>Outstanding Balance</th>
                                        <th>Last Payment</th>
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
                                        $payable = $row['price'] * $months;
                                        $paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =" . $row['id']);
                                        $last_payment = $conn->query("SELECT * FROM payments where tenant_id =" . $row['id'] . " order by unix_timestamp(date_created) desc limit 1");
                                        $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
                                        $last_payment = $last_payment->num_rows > 0 ? date("M d, Y", strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
                                        $outstanding = $payable - $paid;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i++ ?></td>
                                            <td>
                                                <?php echo ucwords($row['name']) ?>
                                            </td>
                                            <td class="">
                                                <p> <b><?php echo $row['house_no'] ?></b></p>
                                            </td>
                                            <td class="">
                                                <p> <b><?php echo number_format($row['price'], 2) ?></b></p>
                                            </td>
                                            <td class="text-right">
                                                <p> <b><?php echo number_format($outstanding, 2) ?></b></p>
                                            </td>
                                            <td class="">
                                                <p><b><?php echo $last_payment ?></b></p>
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
	
	$('#manage-tenant').submit(function(e){
		e.preventDefault()
		//start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_tenant',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					//toast("Data successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},1000)
				}
			}
		})
	})
</script>