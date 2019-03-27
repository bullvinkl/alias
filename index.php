<?php
include('server.php');
?>
<!DOCTYPE html>
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" lang="ru-RU">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Alias</title>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">	
	
<script type="text/javascript">
$(document).ready(function(){
$("#myModal").modal('show');
});
</script>
<style>
.container {
    width: 860px;
    max-width: 100%;
    margin-top: 20px;
}
</style>
  <style id="compiled-css" type="text/css">
      #back-to-top {
    position: fixed;
    bottom: 40px;
    right: 40px;
    z-index: 9999;
    width: 32px;
    height: 32px;
    text-align: center;
    line-height: 30px;
    background: #007bff;
    color: #fff;
    cursor: pointer;
    border: 0;
    border-radius: 2px;
    text-decoration: none;
    transition: opacity 0.2s ease-out;
    opacity: 0.9;
}
#back-to-top:hover {
    background: #2b90fc;
}
#back-to-top.show {
    opacity: 1;
}
#content {
    height: 2000px;
}
  </style>

<script type="text/javascript">


    $(window).load(function(){
      
if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 100);
    });
}

    });

</script>

</head>
<body>
<a href="#" id="back-to-top" title="Back to top"><i class="fas fa-arrow-up"></i></a>
<div class="container">

<?php if (isset($_SESSION['message'])): ?>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">
        <?php
		echo $_SESSION['message_header'];
		unset($_SESSION['message_header']);
	?>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

			<?php
				echo $_SESSION['message']; 
				unset($_SESSION['message']);
			?>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <?php
		echo $_SESSION['message_footer'];
		unset($_SESSION['message_footer']);
	?>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Закрыть</button>
      </div>

    </div>
  </div>
</div>

<?php endif ?>

<?php $results = mysqli_query($db, "SELECT * FROM forwardings WHERE is_list='1' ORDER BY id DESC"); ?>

<ul class="nav nav-tabs">
    <li class="nav-item">
	<a class="nav-link active" href="/alias/">Alias</a>
    </li>
    <li class="nav-item">
	<a class="nav-link" href="/whitelist/">Whitelist</a>
    </li>
    <li class="nav-item">
	<a class="nav-link" href="/greylist/">Greylist</a>
    </li>
    <li class="nav-item">
	<a class="nav-link disabled">Admin panel</a>
    </li>
</ul>
<div>&nbsp;</div>


<table class="table table-sm table-hover">
<caption>List of Aliases</caption>
    <thead>
	<tr>
	    <th>#</th>
	    <th>Alias</th>
	    <th>E-mail</th>
	    <th>Active</th>
	    <th colspan="2"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus"></i> Добавить</button></th>
	</tr>
    </thead>
    <tbody>
<?php
$i=1;
while ($row = mysqli_fetch_array($results)) {
$r_forwarding = str_replace(",","<br>",$row['forwarding']);
?>
	<tr>
	    <td><?php echo $i; $i++; ?></td>
	    <td><?php echo $row['address']; ?></td>
	    <td><?php echo $r_forwarding; ?></td>
	    <!--<td><?php echo $row['active']; ?></td>-->
	    <td><?php
	    $status = $row['active'];
	    if ($status == 1) {
	    echo "<input type=\"checkbox\" name=\"active\" checked=\"checked\" onclick=\"this.checked=!this.checked;\">";
	    } else {
	    echo "<input type=\"checkbox\" name=\"active\" onclick=\"this.checked=!this.checked;\">";
	    }
	    ?></td>
	    <td><a href="server.php?edituser=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i> Редактировать</a></td>
	    <td><a href="server.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить запись?');"><i class="far fa-trash-alt"></i> Удалить</a></td>
	</tr>
<?php
}
?>
    </tbody>
</table>

<form method="post" action="server.php" >

<!-- The Modal -->
<div class="modal fade" id="myModal1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Добавить alias</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

	<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
	<div class="form-group">
		<label>Alias:</label>
		<input class="form-control" type="text" name="alias" id="from" value="" maxlength="99" required autofocus>
	</div>
	<div class="form-group">
		<label>Email:</label>
		<input class="form-control" type="text" name="email" value="">
		<small>Через запятую, если несколько получателей</small>
	</div>
	<div class="form-group">
		<label>Active:</label>
		<input type="checkbox" name="active" checked>
	</div>
	<input type="hidden" name="domain" value="digimap.ru">
	<input type="hidden" name="dest_domain" value="digimap.ru">
	<input type="hidden" name="is_maillist" value="0">
	<input type="hidden" name="is_list" value="1">
	<input type="hidden" name="is_forwarding" value="0">
	<input type="hidden" name="is_alias" value="0">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
	<button type="submit" class="btn btn-success btn-sm" name="save"><i class="fa fa-plus"></i> Добавить</button>
	<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Закрыть</button>
      </div>

    </div>
  </div>
</div>

</form>

</div>
</body>
</html>
