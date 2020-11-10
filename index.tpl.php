<html>
  <head>
  	<title> :: Short Code :: </title>

  </head>
  <body>
  	<form action="" method="POST">
  		<label>Enter Long Url</label>
  		<input type="text" name="longURL">

  		<input type="submit" name="submit" value="Submit">

  	</form>
<?php  if(isset($output)) { ?>
  <h3>Short URL is: <?php echo $output; ?></h3>

 <?php } ?>


  </body>



</html>