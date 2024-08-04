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
                    <b>List of House</b>
                    <span class="">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#exampleModalLong">
                            Add House
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">New Invoice</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" id="manage-house">
                                        <div class="modal-body">
                                            <div class="form-group" id="msg"></div>
                                            <input type="hidden" name="id">
                                            <div class="form-group">
                                                <label class="control-label">House No</label>
                                                <input type="text" class="form-control" name="house_no" required="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Category</label>
                                                <select name="category_id" id="" class="custom-select" required>
                                                    <?php
                                                    $categories = $conn->query("SELECT * FROM categories order by name asc");
                                                    if ($categories->num_rows > 0):
                                                        while ($row = $categories->fetch_assoc()):
                                                            ?>
                                                            <option value="<?php echo $row['id'] ?>">
                                                                <?php echo $row['name'] ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    <?php else: ?>
                                                        <option selected="" value="" disabled="">Please check the category
                                                            list.</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label">Description</label>
                                                <textarea name="description" id="" cols="30" rows="4"
                                                    class="form-control" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Price</label>
                                                <input type="number" class="form-control text-right" name="price"
                                                    step="any" required="">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" id="manage-house">Save
                                                </button>
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
                                        <th>House_Id</th>
                                        <th>House Type</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $house = $conn->query("SELECT h.*,c.name as cname FROM houses h inner join categories c on c.id = h.category_id order by id asc");
                                    while ($row = $house->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $i++ ?>
                                            </td>
                                            <td>
                                                <?php echo $row['house_no'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['cname'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['description'] ?>
                                            </td>
                                            <td>
                                                <?php echo number_format($row['price'], 2) ?>
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
	$('#manage-house').on('reset', function (e) {
		$('#msg').html('')
	})
	$('#manage-house').submit(function (e) {
		e.preventDefault()

		$('#msg').html('')
		$.ajax({
			url: 'ajax.php?action=save_house',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function (resp) {
				console.log(resp);
				if (resp == 1) {
					alert_toast("Data successfully saved", 'success')
					setTimeout(function () {
						location.reload()
					}, 1500)

				}
				else if (resp == 2) {
					$('#msg').html('<div class="alert alert-danger">House number already exist.</div>')
					end_load()
				}
			}
		})
	})
	$('.edit_house').click(function () {
		start_load()
		var cat = $('#manage-house')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='house_no']").val($(this).attr('data-house_no'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id'))
		end_load()
	})
	$('.delete_house').click(function () {
		_conf("Are you sure to delete this house?", "delete_house", [$(this).attr('data-id')])
	})
	function delete_house($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_house',
			method: 'POST',
			data: { id: $id },
			success: function (resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function () {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>