<html>
  <head>
    <title> :: TIC TOC TOE ::</title>

  </head>
  <body>
  	<table border="1">
  		<tr>
  			<?php for($i=0; $i<9; $i++) { $j= $i+1; ?>
  			<td width="60px;"> 
  				<?php
  				if($this->values[$i]==1){
                  echo 'X';
                }else if($this->values[$i]==-1){
                  echo 'O';
                }else{
                  //If noone put a token on this, and if noone won, make a link to allow player X to
                  //put its token here. Otherwise, empty space.
                  if($this->winstate==0){
                    $values_link = $this->values;
                    $values_link[$i]=1;
                    echo '<a href="index.php?values='.implode(',',$values_link).'">&nbsp;</a>';
                  }else{
                    echo '&nbsp;';
                  }
                }
                ?>


  			</td>
  			<?php if($j%3 == 0) { echo "</tr><tr>"; } ?>

  			<?php $j++; } ?>
   
    </table>
<?php
//If someone won, display the message
if($this->winstate!=0){
    echo '<p><b>Player '.(($this->winstate==1)?'X':'O').' won!</b></p>';
}
?>
  </body>
</html>