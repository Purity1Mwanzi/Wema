<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}

include 'config.php';
include 'admin\includes\header.php';
include 'admin\includes\navbar.php';
include 'admin\includes\scripts.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive CRUD Application</title>
    <!-- Include any additional CSS or stylesheets here -->
    <style>
        td {
            vertical-align: middle !important;
        }
    </style>
</head>

<body>
    <ol class="breadcrumb" style="background-color: transparent;">
        <li class="breadcrumb-item"><a href="house_detail.php">Unit</a></li>
        <li class="breadcrumb-item"><a href="add_house.php">Add Unit</a></li>
    </ol>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <form action="" id="manage-category">
                    <div class="card">
                        <div class="card-header">
                            Category Form
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3">Save</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="button"
                                        onclick="$('#manage-category').get(0).reset()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <b>Category List</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $category = $conn->query("SELECT * FROM categories ORDER BY id ASC");
                                while ($row = $category->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo $i++ ?>
                                        </td>
                                        <td class="">
                                            <p><b>
                                                    <?php echo $row['name'] ?>
                                                </b></p>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary edit_category" type="button"
                                                data-id="<?php echo $row['id']; ?>"
                                                data-name="<?php echo $row['name']; ?>">Edit</button>
                                            <button class="btn btn-sm btn-danger delete_category" type="button"
                                                data-id="<?php echo $row['id']; ?>">Delete</button>
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

    <!-- Include any additional scripts or JavaScript libraries here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#manage-category').submit(function (e) {
            e.preventDefault()
            $.ajax({
                url: 'ajax.php?action=save_category',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function (resp) {
                    if (resp == 1) {
                        setTimeout(function () {
                            location.reload()
                        }, 1500)

                    } else if (resp == 2) {
                        alert_toast("Data successfully updated", 'success')
                        setTimeout(function () {
                            location.reload()
                        }, 1500)

                    }
                }
            })
        })


        function confirmDelete(message, action, data) {
            var result = confirm(message);
            if (result) {
                action(data);
            } else {
                // Handle cancellation
            }
        }

        $('.delete_category').click(function () {
            var id = $(this).attr('data-id');
            confirmDelete("Are you sure to delete this category?", delete_category, id);
        })

        function delete_category($id) {

            $.ajax({
                url: 'ajax.php?action=delete_category',
                method: 'POST',
                data: {
                    id: $id
                },
                success: function (resp) {
                    if (resp == 1) {
                        setTimeout(function () {
                            location.reload()
                        }, 1500)

                    }
                }
            })
        }
    </script>
</body>

</html>