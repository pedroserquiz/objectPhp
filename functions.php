<?php 
/*
*
* Student name: Pedro Alberto Serquiz de Azevedo
* Student number: 300239189
*
*/

//start the session
session_start();
//Include the data as required
require_once 'assets/data/data.php';
//Declaring variables to use it globally
global $dLevel, $qQtty, $count, $questions;
//Get the values from the selects by POST
$dLevel = $_POST['dLevel'];
$qQtty = $_POST['qQtty'];
//Creatubg the array for questions
$questions = array();
//Initiating a count variable
$count = 0;

//Function to generate the selection options
function selectGen($optQtty){
	for ($i=0; $i < $optQtty; $i++) { 
		if ($optQtty == 3 ) {
			?><option value="<?=$i+1?>"><?php if($i == 0){echo "Easy";}elseif($i == 1) {echo "Medium";}elseif($i==2){echo "Difficult";} ?></option>";
		<?php }else{ ?>
			<option value="<?=$i+1?>"><?=$i+1?></option>
		<?php
		}
	}
}

//function to get the data in the data.php to use it
function coCiGen(){
  $level = $GLOBALS['dLevel'];
  $cityResult;
  //get all the data in the data.php
  $allCountries = json_decode($GLOBALS['countryJsonData']);
  //shuffle all the data in the array
  shuffle($allCountries);
  $selectedCountry = null;
  //Foreach in the array to get the results (comparing the level)
  foreach ($allCountries as $country) {
    if ($country->level == $level) {
        $selectedCountry = $country;
        break;
    }
  }	
  	//declaring global variabels with the name of the country and the answer
  	global $countryResult, $cityResult;
  	$countryResult = $selectedCountry->Country;
	$cityResult = $selectedCountry->City;
	
  	//Generating cities
    global $selectedCities;
    $selectedCities = array();
    $allCities = json_decode($GLOBALS['cityJsonData']);
    shuffle($allCities);
    for ($i = 0; $i < 3; $i++) {
        $selectedCities[] = $allCities[$i];
    }
    //Adding the result to the array to do the shuffle
    array_push($selectedCities, $cityResult);
    shuffle($selectedCities);
    //echo $q1 = json_encode($selectedCities[0]);
    //Giving for each variable one different city
    global $q1, $q2, $q3, $q4;
    $q1 = $selectedCities[0];
    $q2 = $selectedCities[1];
    $q3 = $selectedCities[2];
    $q4 = $selectedCities[3];

    //print_r($selectedCities);
	
}

//function to get the country or city name by passing an parameter
function printQuestion($result){
	coCiGen();
    global $q1, $q2, $q3, $q4, $countryResult, $cityResult, $selectedCities, $questions;
    //checking the parameter to print the right data
    if ($result == 'country') {
		echo $countryResult;
	}elseif ($result=='city') {
		echo $cityResult;
	}
}


//Function to print the final content
function countAnswers(){

	$result = $_GET['result'];
	//Checking if the user clicked in the right form button
	if ($result=="ok") {
		//creating sessions of: total - total of right user answers, n - size of the array questions, array - the array/object data
		$_SESSION["total"] = 0;
		$_SESSION["n"];
		//Checking the answer
		for ($i=0; $i < $_SESSION["n"]; $i++) { 
			$_SESSION["array"][$i]->userResponse = $_POST['cities'.$i];
			if ($_SESSION["array"][$i]->answer == $_SESSION["array"][$i]->userResponse) {
				$_SESSION["array"][$i]->isCorrect = 1;
				$_SESSION["total"]++;
			}
		}
		//creating a message to be displayed
		$message = "<script>Materialize.toast('Check your answers!', 4000)</script>";
		//print the message
		echo $message;
		?>	
		
		<!--Final result - Table with all the information-->
		<div class="container">
			<div class="row">
				<table>
			        <thead>
			          <tr>
			              <th data-field="country">Country</th>
			              <th data-field="userAnswer">Right answer</th>
			              <th data-field="answer">Your answer</th>
			              <th data-field="finalResult">Result</th>
			          </tr>
			        </thead>

			        <tbody>
			        	<?php foreach ($_SESSION["array"] as $key) { ?>
			        		<tr>
					        	<td><?=$key->questionText?></td>
					        	<td><?=$key->answer?></td>
					        	<td><?=$key->userResponse?></td>
					        	<td>
					        		<?php 
					        			if($key->isCorrect == 0){
					        				$icon = "<i class=\"small red-text material-icons\">thumb_down</i>";
					        			}else{
					        				$icon = "<i class=\"small green-text material-icons\">thumb_up</i>";
					        			}
					        			echo $icon;

					        		?>
					        	</td>

					        </tr>

			        	<?php } ?>
			          
			        </tbody>
			    </table>

				<div class="card-panel red lighten-5">
				   	<span class="red-text text-darken-2">You got <?php echo $_SESSION["total"]." of ".$_SESSION["n"]. " questions"; ?></span>
				</div>
			</div>
			<a id="showCardBtn" href="index.php" class="waves-effect waves-light btn">Play again</a>
			<a id="showCardBtn" onclick="window.print();" class="waves-effect waves-light btn">Print my result</a>

		</div>

		

<?php
// destroy the session
session_destroy(); 
	}
}

?>
