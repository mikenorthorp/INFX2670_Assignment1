<?php

// Field values
$nameField = "";
$likeField = "";
$emailField = "";

// Error values, get written too when an error occurs
$nameError = "";
$likeError = "";
$companyError = "";
$browserError = "";
$timePerDayError = "";
$emailCheckError = "";
$emailError = "";
$someEmptyError = "";
$errorsOnPage = "";

// Checks and counters
$emptyCheck = 0;
$errorsOccur = 0;

// Views
$displayNone = "";
$resultsView = "display:none";

// Checkbox variables
$browserCheckedCount = 0;
$chrome = "";
$firefox = "";
$safari = "";

// Radio button variables
$google = "";
$microsoft = "";
$apple = "";

// If a form is submitted, set all variables to their entered inputs and 
// sanatize them
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$nameField = htmlspecialchars($_POST["name_field"]);
	$likeField = htmlspecialchars($_POST["like_field"]);
	$emailField = htmlspecialchars($_POST["email_field"]);

	// Check to make sure fields pass all validation

	// Validate name field
	if (empty($nameField)) {
		$nameError = "You must enter a name";
		$nameField = "";
		$emptyCheck = 1;
		$errorsOccur += 1;
	}

	// Validate like field, must not be empty and contains validated in the text
	if (empty($likeField)) {
		$likeError = "You must enter some text in this field";
		$likeField = "";
		$emptyCheck = 1;
		$errorsOccur += 1;
	} elseif(strpos($likeField,"validated") === false) {
		$likeError = "This text area must contain the word validated";
		$errorsOccur += 1;
	}

	// Check if radio button is selected for company
	if (!isset($_POST['companies'])) {
		$companyError = "Please select a favorite company";
		$emptyCheck = 1;
		$errorsOccur += 1;
	} else {
		// Save the state of the current checked radio button
		if ($_POST['companies'] == "Google") {
			$google = "checked";
		} elseif ($_POST['companies'] == "Microsoft") {
			$microsoft = "checked";
		} else if ($_POST['companies'] == "Apple") {
			$apple = "checked"; 
		}
	}

	// Validation for checkboxes, makes sure at least two are checked.
	if (!isset($_POST['browsers'])) {
		$browserError = "Please select two favorite browsers";
		$emptyCheck = 1;
		$errorsOccur += 1;
	} else {
		// Sees which checkboxes are checked and records the number
		foreach($_POST['browsers'] as $browser) {
			// Keeps the values if they are valid
			if ($browser == "firefox") {
				$firefox = "checked";
				$browserCheckedCount += 1;
			} elseif ($browser == "chrome") {
				$chrome = "checked";
				$browserCheckedCount += 1;
			} elseif ($browser == "safari") {
				$safari = "checked";
				$browserCheckedCount += 1;
			}
		}

		// Check if at least two browsers are checked
		if ($browserCheckedCount < 2) {
			$browserError = "You MUST select at least two favorite browsers";
			$emptyCheck = 1;
			$errorsOccur += 1;	
		}
	}

	// Validation for 


	// If validation does not pass
	if ($errorsOccur > 0) {
		$errorsOnPage = "There are " . $errorsOccur . " error(s) on the page";
		if($emptyCheck == 1) {
			$someEmptyError = "You must fill out every field except email and email checkbox";
		}
	} else { // Validation passes
		$displayNone = 'style="display:none"';
		$resultsView = "";
	}
	
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Internet is Awesome</title>
	<link rel="stylesheet" href="main.css" type="text/css">
</head>
<body>
<div id="content">
	<h1> INFX 2670 Assignment 1 - Mike Northorp </h1>
	<div id="form">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" <?php echo $displayNone;?>>
			<h1> Internet is Awesome Survey </h1>
			<p>Name:</p><input type="text" name="name_field" size=20 value="<?php echo $nameField;?>">
			<span class="error"><?php echo $nameError;?></span><br>

			<p>Write why you like the internet</p>
			<textarea name="like_field" cols=40 rows=8><?php echo $likeField;?></textarea> 
			<span class="error"><?php echo $likeError;?></span><br>

			<p>Pick your favorite</p><br>
			<input type="radio" name="companies" value="Google" <?php echo $google;?>> Google<br>
			<input type="radio" name="companies" value="Microsoft" <?php echo $microsoft;?>> Microsoft<br>
			<input type="radio" name="companies" value="Apple" <?php echo $apple;?>> Apple<br>
			<span class="error"><?php echo $companyError;?></span><br>

			
			<p>Pick top two favorite browsers</p><br>
			<input type="checkbox" name="browsers[]" value="chrome" <?php echo $chrome;?>> Chrome<br>
			<input type="checkbox" name="browsers[]" value="firefox" <?php echo $firefox;?>> Firefox<br>
			<input type="checkbox" name="browsers[]" value="safari" <?php echo $safari;?>> Safari<br>
			<span class="error"><?php echo $browserError;?></span><br>

			<p>How long do you spend on the internet a day?</p>
			<select>
			  <option value="time_per_day">2-10 Hours</option>
			  <option value="time_per_day">1-2 Hours</option>
			  <option value="time_per_day">FOREVERRRR</option>
			</select>
			<span class="error"><?php echo $timePerDayError;?></span><br>

			<p>If you wish to receive the submission as an email, enter email and check box below</p>
			<div id="email_toggle">
				<input type="checkbox" name="email_check" value="send_email"> Send Email
				<span class="error"><?php echo $emailCheckError;?></span><br>
				<input type="text" name="email_field" size=20>
				<span class="error"><?php echo $emailError;?></span><br>
			</div>

			<input type="submit" value="Submit">
			<span class="error"><?php echo $someEmptyError;?></span><br>
			<span class="error"><?php echo $errorsOnPage;?></span>
		</form>
	</div>

	<div id="results" style="<?php echo $resultsView;?>">
		<h1>Results</h1>
	</div>
</div>

</body>
</html>