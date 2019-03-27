<?php 
	session_start();
	$db = mysqli_connect('localhost', 'vmailadmin', '', 'vmail');
        // Check connection
        if (!$db)
           {
           die("Connection error: " . mysqli_connect_error());
           }

/* добавить пользователя */
if (isset($_POST['save'])) {
	$alias = $_POST['alias'];
	$email = $_POST['email'];
	$domain = $_POST['domain'];
	$dest_domain = $_POST['dest_domain'];
	$is_maillist = $_POST['is_maillist'];
	$is_list = $_POST['is_list'];
	$is_forwarding = $_POST['is_forwarding'];
	$is_alias = $_POST['is_alias'];
	$active = (isset($_POST['active'])) ? 1 : 0;
//	$dir = "/home/ftp/$username";
//	if ($temp == 0){ $temp_value = "Постоянный"; }
//		else if($temp == 1){ $temp_value = "Временный"; }
//	if ($temp == 0){
//		    $temp_value = "";
//		    $temp_value_2 = "Тип пользователя: <strong>Постоянный</strong>";
//		}
//		else if($temp == 1){
//		    $temp_value = "Дата удаления: <font color=\"#990000\"><strong>$date_end</strong></font>";
//		    $temp_value_2 = "Тип пользователя: <strong>Временный</strong>";
//		}
	/*проверка, еслть ли такой пользователь*/
	$results = mysqli_query($db, "SELECT id FROM forwardings WHERE adresses='$alias'");
	$row = mysqli_fetch_array($results);
	if (!empty($row['id'])) {
		$_SESSION['message_header'] = "Ошибка при добавлении";
		$_SESSION['message'] = "Алиас <strong>$alias</strong> уже есть в базе, попробуйте ввести другой.";
		$_SESSION['message_footer'] = "";
	}
else {
		mysqli_query($db, "INSERT INTO forwardings (address, forwarding, domain, dest_domain, is_maillist, is_list, is_forwarding, is_alias, active) VALUES ('$alias', '$email', '$domain', '$dest_domain', '$is_maillist', '$is_list', '$is_forwarding', '$is_alias', '$active')");
		mysqli_query($db, "INSERT INTO alias (address, domain, active) VALUES ('$alias', 'digimap.ru', 1)");
		$_SESSION['message_header'] = "Алиас добавлен";
		$_SESSION['message'] = "Алиас: <strong>$alias</strong>@digimap.ru<br>
		Email: <strong>$email</strong><br>";
//		$temp_value_2<br>
//		Дата добавления: <strong>$date</strong><br>
//		$temp_value<br>
//		Данные отправлены на: <strong>$email</strong>";
		$_SESSION['message_footer'] = "";
//		mkdir("/home/ftp/$username",0755);
//		mkdir("$dir",0777);
	}
		header('location: index.php');
}

/* вывод формы редактирования пользователя */
	if (isset($_GET['edituser'])) {
		$id = $_GET['edituser'];
		$results = mysqli_query($db, "SELECT * FROM forwardings WHERE id=$id");
		$row = mysqli_fetch_array($results);
//		if ($row['temp'] == 1){
//		    $temp_value_1 = "checked";
//		    $temp_value_2 = "";
//		}
//		else if ($row['temp'] == 0){
//		    $temp_value_1 = "";
//		    $temp_value_2 = "checked";
//		}
		$alias = $row['address'];
		$email = $row['forwarding'];
                $active = $row['active'];
                if ($active == "1") {
		    $act = 'checked';
		} else {
		    $act = '';
		}
		$date = date('Y-m-d H:i:s');
//		$date_end = date('Y-m-d', strtotime("+1 month"));
//		$dir = $row['dir'];
//		$local_ip = $_SERVER['REMOTE_ADDR'];
		$_SESSION['message_header'] = "Редактировать алиас";
		$_SESSION['message'] = "<form method=\"post\" action=\"server.php\">
		<input type=\"hidden\" name=\"id\" value=\"$id\">
		<div class=\"form-group\">
		<label>Алиас:</label>
		<input class=\"dis form-control\" type=\"text\" name=\"alias\" value=\"$alias\" maxlength=\"99\">
		</div>
		<div class=\"form-group\">
		<label>E-mail:</label>
                <textarea class=\"form-control\" rows=\"3\" name=\"email\">$email</textarea>
		<small>Через запятую, если несколько получателей</small>
		</div>
		<!--<input type=\"hidden\" name=\"date\" value=\"$date\">-->
		<div class=\"form-group\">
		<label><input type=\"checkbox\" name=\"active\" $act> Active</label>
		</div>";
		$_SESSION['message_footer'] = "<button class=\"btn btn-success btn-sm\" type=\"submit\" name=\"update\"><i class=\"fas fa-sync\"></i> Обновить</button>
		</form>";
		header('location: index.php');
}

/* Обновление */
	if (isset($_POST['update'])) {
		$id = $_POST['id'];
		$alias = $_POST['alias'];
		$email = $_POST['email'];
		$date = $_POST['date'];
		$active = (isset($_POST['active'])) ? 1 : 0;
		$results = mysqli_query($db, "SELECT id from `forwardings` WHERE address='$alias' AND id!='$id'");
		$row = mysqli_fetch_array($results);
		if (!empty($row['id'])) {
		    $_SESSION['message_header'] = "Ошибка при обновлении";
		    $_SESSION['message'] = "Алиас $alias уже есть в базе";
		    $_SESSION['message_footer'] = "";
		} else {
//		$date_end = $_POST['date_end'];
//		$local_ip = $_POST['local_ip'];
//		if ($temp == 0){ $temp_value = "Постоянный"; }
//		else if($temp == 1){ $temp_value = "Временный"; }
//		if ($temp == 0){
//		    $temp_value = "";
//		    $temp_value_2 = "Тип пользователя: <strong>Постоянный</strong>";
//		}
//		else if($temp == 1){
//		    $temp_value = "Дата удаления: <font color=\"#990000\"><strong>$date_end</strong></font>";
//		    $temp_value_2 = "Тип пользователя: <strong>Временный</strong>";
//		}
		mysqli_query($db, "UPDATE forwardings SET address='$alias', forwarding='$email', active='$active'  WHERE id=$id");
		$_SESSION['message_header'] = "Алиас обновлен";
		$_SESSION['message'] = "Алиас: <strong>$alias</strong><br>
		E-mail: <strong>$email</strong><br>";
		$_SESSION['message_footer'] = "";
		}
		header('location: index.php');
	}


/* удаление */
if (isset($_GET['del'])) {
	$id = $_GET['del'];
	$results = mysqli_query($db, "SELECT * FROM forwardings WHERE id=$id");
	$row = mysqli_fetch_array($results);
	$alias = $row['address'];
	$email = $row['forwarding'];
//	$username = $_GET['username'];
//	$dir = $row['dir'];
//	$local_ip = $_SERVER['REMOTE_ADDR'];
	$date = date('Y-m-d H:i:s');
	mysqli_query($db, "DELETE FROM forwardings WHERE id=$id");
        mysqli_query($db, "DELETE FROM alias WHERE address=$alias");
	$_SESSION['message_header'] = "Алиас удален";
	$_SESSION['message'] = "Алиас: <strong>$alias</strong>";
	$_SESSION['message_footer'] = "";

	header('location: index.php');
}

?>
