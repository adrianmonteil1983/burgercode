<?php
	require 'database.php';

	$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

	if(!empty($_POST))
	{
		$name            = checkInput($_POST['name']);
		$description     = checkInput($_POST['description']);
		$price           = checkInput($_POST['price']);
		$category        = checkInput($_POST['category']);
		$image           = checkInput($_FILES['image']['name']);// cours john codeur section 9 admin ajouter un item part 2.
		$imagePath       = '../images/' . basename($image);
		$imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
		$isSucces        = true;
		$isUpLoadSuccess = false;

		if(empty($name))
		{
			$nameError = 'ce champ est obligatoire';
			$isSucces  = false;
		}
		if(empty($description))
		{
			$descriptionError = 'ce champ est obligatoire';
			$isSucces  = false;
		}
		if(empty($price))
		{
			$priceError = 'ce champ est obligatoire';
			$isSucces  = false;
		}
		if(empty($category))
		{
			$categroryError = 'ce champ est obligatoire';
			$isSucces  = false;
		}
		if(empty($image))
		{
			$imageError = 'ce champ est obligatoire';
			$isSucces  = false;
		}
		else
		{
			$isUpLoadSuccess = true;
			if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
			{
				$imageError = " format pris en compte : jpg, jpeg, png, gif ";
				$isUpLoadSuccess = false;
			} 
			if(file_exists($imagePath))
			{
				$imageError = "modifier le nom du fichier";
				$isUpLoadSuccess = false;
			}
			if($_FILES["image"]["size"]> 500000)
			{
				$imageError = "Le fichier ne doit pas depasser les 500KB";
				$isUpLoadSuccess = false;
			}
			if($isUpLoadSuccess)
			{
				echo $imagePath;
				echo $image;
				if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
				{
					$imageError = "probleme de telechargement";
					$isUpLoadSuccess = false;
				}
			}

		}
		if($isSucces && $isUpLoadSuccess)
		{
			$db = Database::connect();
			$statement = $db->prepare("INSERT INTO items (name,description,price,category,image) values (?,?,?,?,?)");
			$statement->execute(array($name, $description, $price, $category, $image));
			Database::disconnect();
			header("location: index.php");
		}
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
				<h1><strong>Ajouter un item</strong></h1>
				<br>
				<form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="name">Nom:</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
						<span class="help-inline"><?php echo $nameError;?></span>
					</div>
					<div class="form-group">
						<label for="description">Description:</label>
						<input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
						<span class="help-inline"><?php echo $descriptionError;?></span>
					</div>
					<div class="form-group">
						<label for="price">Price:</label>
						<input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
						<span class="help-inline"><?php echo $priceError;?></span>
					</div>
					<div class="form-group">
						<label for="category">Categories:</label>
						<select class="form-control" id="category" name="category">
							<?php
								$db = Database::connect();

								foreach ($db->query('SELECT * FROM categories') as $row) 
								{
									echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>'; 
								}
								Database::disconnect();
							?>
						</select>
						<span class="help-inline"><?php echo $categoryError;?></span>
					<div class="form-group">
						<label for="image">Selectionnez une image</label>
						<input type="file" id="image" name="image">
						<span class="help-inline"><?php echo $imageError;?></span>
					</div>
					<div class="form-actions">
						<button type=submit class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
						<a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
					</div>
				</form>						
			</div>
		</div>
	</body>
</html>