<?php
	session_start();
	ini_set('display_errors', 1);
	class Action
	{
		private $conn;

		public function __construct()
		{
			ob_start();
			include 'config.php';

			$this->conn = $conn;
		}
		function __destruct()
		{
			$this->conn->close();
			ob_end_flush();
		}

		function save_category()
		{
			extract($_POST);
			$data = " name = '$name' ";
			if (empty($id)) {
				$save = $this->conn->query("INSERT INTO categories set $data");
			} else {
				$save = $this->conn->query("UPDATE categories set $data where id = $id");
			}
			if ($save)
				return 1;
		}

		function delete_category()
		{
			extract($_POST);
			$delete = $this->conn->query("DELETE FROM categories where id = " . $id);
			if ($delete) {
				return 1;
			}
		}

		function save_house()
		{
			extract($_POST);
			$data = " house_no = '$house_no' ";
			$data .= ", description = '$description' ";
			$data .= ", category_id = '$category_id' ";
			$data .= ", price = '$price' ";
			$chk = $this->conn->query("SELECT * FROM houses where house_no = '$house_no' ")->num_rows;
			if ($chk > 0) {
				return 2;
				exit;
			}
			if (empty($id)) {
				$save = $this->conn->query("INSERT INTO houses set $data");
			} else {
				$save = $this->conn->query("UPDATE houses set $data where id = $id");
			}
			if ($save)
				return 1;
		}
		function delete_house()
		{
			extract($_POST);
			$delete = $this->conn->query("DELETE FROM houses where id = " . $id);
			if ($delete) {
				return 1;
			}
		}
		function save_tenant()
		{
			extract($_POST);
			$data = " fname = '$fname' ";
			$data .= ", lname = '$lname' ";
			$data .= ", email = '$email' ";
			$data .= ", contact = '$contact' ";
			$data .= ", date_in = '$date_in' ";
			$data .= ", house_id = '$house_id' ";

			if (empty($id)) {

				$save = $this->conn->query("INSERT INTO tenant set $data");
			} else {
				$save = $this->conn->query("UPDATE tenant set $data where id = $id");
			}
			if ($save)
				return 1;

		}

		function delete_tenant()
		{
			extract($_POST);
			$delete = $this->conn->query("UPDATE tenant set status = 0 where id = " . $id);
			if ($delete) {
				return 1;
			}
		}


		function get_tdetails()
		{
			extract($_POST);
			$data = array();
			$tenant = $this->conn->query("SELECT t.*,concat(t.lname,', ',t.fname) as name,h.house_no,h.price FROM tenant t inner join houses h on h.id = t.house_id where t.id = {$id} ");
			foreach ($tenant->fetch_array() as $k => $v) {
				if (!is_numeric($k)) {
					$$k = $v;
				}
			}
			$months = abs(strtotime(date('Y-m-d') . " 23:59:59") - strtotime($date_in . " 23:59:59"));
			$months = floor(($months) / (30 * 60 * 60 * 24));
			$months = max(1, $months);

			$data['months'] = $months;
			$payable = abs($price * $months);
			$data['payable'] = number_format($payable, 2);
			$paid = $this->conn->query("SELECT SUM(amount) as paid FROM payments where id != '$pid' and tenant_id =" . $id);
			$last_payment = $this->conn->query("SELECT * FROM payments where id != '$pid' and tenant_id =" . $id . " order by unix_timestamp(date_created) desc limit 1");
			$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
			$data['paid'] = number_format($paid, 2);
			$data['last_payment'] = $last_payment->num_rows > 0 ? date("M d, Y", strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
			$data['outstanding'] = number_format($payable - $paid, 2);
			$data['price'] = number_format($price, 2);
			$data['name'] = ucwords($name);
			$data['rent_started'] = date('M d, Y', strtotime($date_in));

			return json_encode($data);
		}

		function save_payment()
		{
			extract($_POST);
			$data = "";
			foreach ($_POST as $k => $v) {
				if (!in_array($k, array('id', 'ref_code')) && !is_numeric($k)) {
					if (empty($data)) {
						$data .= " $k='$v' ";
					} else {
						$data .= ", $k='$v' ";
					}
				}
			}
			if (empty($id)) {
				$save = $this->conn->query("INSERT INTO payments set $data");
				$id = $this->conn->insert_id;
			} else {
				$save = $this->conn->query("UPDATE payments set $data where id = $id");
			}

			if ($save) {
				return 1;
			}
		}
		function delete_payment()
		{
			extract($_POST);
			$delete = $this->conn->query("DELETE FROM payments where id = " . $id);
			if ($delete) {
				return 1;
			}
		}
	}


?>