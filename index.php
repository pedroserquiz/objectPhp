<?php 
/*
*
* Student name: Pedro Alberto Serquiz de Azevedo
* Student number: 300239189
*
*/
require 'functions.php';?>
<!DOCTYPE html>
<html>
<head>
  <title>Object - PHP</title>
  <meta charset="UTF-8">
<!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" media="screen,projection,print">
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="assets/css/materialize.min.css"  media="screen,projection,print"/>
<!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="assets/js/materialize.min.js"></script>
  <script>
     $(document).ready(function() {
        $('select').material_select();
    });
  </script>
</head>
<body>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo center">Objects PHP</a>
    </div>
  </nav>
  	<div class="container" style="margin-top: 50px;">
  		<?php if (empty($_SESSION["array"])) { ?>
  		<div class="row">
	  		<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
				<div class="input-field col s12">
					<select name="dLevel">
						<option value="" disabled selected>Choose the difficult level</option>
						<?php selectGen(3); ?>
					</select>
					<label>Difficult level</label>
				</div>
				<div class="input-field col s12">
					<select name="qQtty">
						<option value="" disabled selected>Select how many questions do you want</option>
						<?php selectGen(10); ?>
					</select>
					<label>Quantity of questions</label>
				</div>
				<input id="showCardBtn" type="submit" value="Start the game" class="waves-effect waves-light btn">
			</form>
  		</div>
  		<?php } ?>
  		<?php if (isset($dLevel) && isset($qQtty)) { ?>
  		<div class="row">
  			
		    <form action="index.php?result=ok" method="POST">
			<?php for ($i=0; $i < $qQtty; $i++) { ?>

			<div class="card-panel">
		    	<span id="question" class="blue-text text-darken-2">QUESTION: <?php echo "What's the capital of "; printQuestion('country');?></span>
		    </div>
		    <?php 
			    
	        	$questions[$i] = (object) ["questionText" => $countryResult,
			    "options" => [$q1, $q2, $q3, $q4],
			    "answer" => $cityResult,
			    "isCorrect" => 0,
			    "userResponse" => ""];
		    ?>
		    <div id="options">			  	
			  	<p>
			      <input name="cities<?=$i?>" type="radio" value="<?=$q1?>" id="city<?php echo $count;?>"/>
			      <label for="city<?php echo $count; $count++?>"><?=$q1?></label>
			    </p>
			    <p>
			      <input name="cities<?=$i?>" type="radio" value="<?=$q2?>" id="city<?php echo $count;?>"/>
			      <label for="city<?php echo $count; $count++?>"><?=$q2?></label>
			    </p>
			    <p>
			      <input name="cities<?=$i?>" type="radio" value="<?=$q3?>" id="city<?php echo $count;?>"/>
			      <label for="city<?php echo $count; $count++?>"><?=$q3?></label>
			    </p>
			      <p>
			        <input name="cities<?=$i?>" type="radio" value="<?=$q4?>" id="city<?php echo $count;?>"/>
			        <label for="city<?php echo $count; $count++?>"><?=$q4?></label>
			    </p>
			  </div>
			  <?php } ?>
			  <p><input type="submit" value="answer" id="showCardBtn" class="waves-effect waves-light btn"></p>
			</form>
		</div>
		<?php } 
		elseif (empty($_SESSION["array"]))
		{
			echo "<script>Materialize.toast('Please select the difficult level and the total of questions to start', 4000)</script>";
		} ?>
	</div>
	<?php 
		countAnswers();
		$_SESSION["n"] = count($questions);
		$_SESSION["array"] = $questions;
		
	?>
  </body>
  </html>
