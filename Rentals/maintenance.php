<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}

include 'config.php';
include ('admin\includes\header.php');
include ('admin\includes\navbar.php');
include ('admin\includes\scripts.php');



$query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");


?>
<ol class="breadcrumb" style="background-color: transparent;">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="maintenance.php">Maintenance</a></li>
</ol>


<div class="layout__content">
    <div id="feedbackModal"></div>
    <div>
        <div class="MuiBackdrop-root jss1" aria-hidden="true"
            style="opacity: 0; transition: opacity 195ms cubic-bezier(0.4, 0, 0.2, 1) 0ms; visibility: hidden;">
            <div class="MuiCircularProgress-root MuiCircularProgress-indeterminate" role="progressbar"
                style="width: 40px; height: 40px;">
                <svg class="MuiCircularProgress-svg" viewBox="22 22 44 44">
                    <circle class="MuiCircularProgress-circle MuiCircularProgress-circleIndeterminate" cx="44" cy="44"
                        r="20.2" fill="none" stroke-width="3.6"></circle>
                </svg>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-1 pb-1 border-bottom row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-end row">
                            <button type="button" class="mb-1 mx-2 shadow btn btn-secondary"
                                style="background-color: #4e73df; border-bottom-color: #4e73df;">
                                <a href="add_maintenance.php">
                                    <span style="color: white; text-decoration: none;"><i
                                            class="fa fa-fw fa-plus mr-1"></i>Add Maintenance</span>

                                </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9" style="min-width: 240px;">

                <div class="mb-2 _2FwYJSSiz4rgRt6CoVCwk7 card">
                    <div
                        class="d-flex justify-content-between h5 bg-white text-indigo _1wKHkO6cYDJ1VuvERIhU4e card-header">
                        <span style="color: rgb(22, 15, 171);">Maintenance</span>
                        <a class="collapse show" href="#" data-toggle="collapse" data-target="#collapse"
                            aria-expanded="true" aria-controls="collapse">
                            <i class="ml-auto fa fa-fw fa-minus"></i>
                        </a>
                    </div>
                    <div id="collapse" class="collapse show">
                        <div class="pt-0 card-body">
                            <div class="table-responsive">
                                <table id="maintenaceTable" class="mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Short Summary</th>
                                            <th>Unit ID/Name</th>
                                            <th>Category</th>
                                            <th>Expense</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <nav class="" aria-label="pagination">
                                            <ul class="pagination pagination-sm">
                                                <li class="page-item disabled">
                                                    <a href="#" class="page-link" aria-label="Previous">
                                                        <span aria-hidden="true">‹</span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                </li>
                                                <li class="page-item disabled">
                                                    <a href="#" class="page-link" aria-label="Next">
                                                        <span aria-hidden="true">›</span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>