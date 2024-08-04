<?php
ob_start();
$action = $_GET['action'];

include 'admin.php';

$crud = new Action();

if ($action == "save_category") {
	$save = $crud->save_category();
	if ($save)
		echo $save;
}

if ($action == "delete_category") {
	$delete = $crud->delete_category();
	if ($delete)
		echo $delete;
}

if ($action == "save_house") {
	$save = $crud->save_house();
	if ($save)
		echo $save;
}
if ($action == "delete_house") {
	$save = $crud->delete_house();
	if ($save)
		echo $save;
}

if ($action == "save_tenant") {
	$save = $crud->save_tenant();
	if ($save)
		echo $save;
}
if ($action == "get_tdetails") {
	$get = $crud->get_tdetails();
	if ($get)
		echo $get;
}
if ($action == "save_payment") {
	$save = $crud->save_payment();
	if ($save)
		echo $save;
}

if ($action == "delete_payment") {
	$save = $crud->delete_payment();
	if ($save)
		echo $save;
}

ob_end_flush();

?>