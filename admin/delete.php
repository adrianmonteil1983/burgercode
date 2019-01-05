<?php
	require "database.php";

	if(!empty($_GET['id']))
	{
		$id = checkInput($_GET['id']);
	}

	if(!empty($_POST))
	{
		
		$id = checkInput($_POST['id']);
		$db = Database::connect();
		$statement = $db->prepare('DELETE FROM items WHERE id = ?'); 
		$statement->execute(array($id));
		Database::disconnect();
		header("location:index.php");
	}

	function checkInput($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Burger Code</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet">
</head>
	<body>
		<h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
		<div class="container admin">
			<div class="row">
				<div>
					<h1><strong>Supprimer un item</strong></h1>
					<form class="form" role="form" action="delete.php" method="post">
						<input type="hidden" name="id" value="<?php echo $id ?>"/>
						<p class="alert alert-warning"> Etes-vous de vouloir bien supprimer</p>
						<div class="form-actions">
							<button type=submit class="btn btn-default">oui</button>
							<a class="btn btn-default" href="index.php">non</a>
						</div>	
					</form>
					
				</div>
			</div>
		</div>
	</body>
</html>