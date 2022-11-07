<?php 
 
require_once 'functions.php'; 
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>PHP Event Calendar by CodexWorld</title>
<meta charset="utf-8">


<link rel="stylesheet" href="style.css">


<script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
	<div id="calendar_div">
		<?php echo getCalender(); ?>
	</div>
</body>
</html>