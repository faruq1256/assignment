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
  <h3>Short URL is: <a href="<?php echo $output; ?>" target="__blank"><?php echo $output; ?></a></h3>

 <?php } ?>


  </body>



</html>