<?php

// Field values
$nameField = "";
$likeField = "";
$emailField = "";
$timePerDayField = "";
$companyField = "";

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
$emailChecked = 0;
$emailEmpty = 0;
$fullyValidated = 0;

// Views
$displayNone = "";
$resultsView = "display:none";

// Checkbox values
$browserCheckedCount = 0;
$chrome = "";
$firefox = "";
$safari = "";

// Radio button values
$google = "";
$microsoft = "";
$apple = "";

// Selected time values
$firstOption = "";
$secondOption = "";
$thirdOption = "";

// If a form is submitted, set all variables to their entered inputs and 
// sanatize them
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$nameField = filter_input(INPUT_POST, 'name_field', FILTER_SANITIZE_SPECIAL_CHARS);
	$likeField = filter_input(INPUT_POST, 'like_field', FILTER_SANITIZE_SPECIAL_CHARS);
	$emailField = filter_input(INPUT_POST, 'email_field', FILTER_SANITIZE_SPECIAL_CHARS);


	// Check to make sure fields pass all validation

	// Validate name field
	if (empty($nameField)) {
		$nameError = "You must enter a name";
		$nameField = "";
		$emptyCheck = 1;
		$errorsOccur++;
	}

	// Validate like field, must not be empty and contains validated in the text
	if (empty($likeField)) {
		$likeError = "You must enter some text in this field";
		$likeField = "";
		$emptyCheck = 1;
		$errorsOccur++;
	} elseif(strpos($likeField,"validated") === false) {
		$likeError = "This text area must contain the word validated";
		$errorsOccur++;
	}

	// Check if radio button is selected for company
	if (!isset($_POST['companies'])) {
		$companyError = "Please select a favorite company";
		$emptyCheck = 1;
		$errorsOccur++;
	} else {
		// Save the state of the current checked radio button
		if ($_POST['companies'] == "Google") {
			$google = "checked";
			$companyField = "Google";
		} elseif ($_POST['companies'] == "Microsoft") {
			$microsoft = "checked";
			$companyField = "Microsoft";
		} elseif ($_POST['companies'] == "Apple") {
			$apple = "checked"; 
			$companyField = "Apple";
		}
	}

	// Validation for checkboxes, makes sure at least two are checked.
	if (!isset($_POST['browsers'])) {
		$browserError = "Please select at least two favorite browsers";
		$emptyCheck = 1;
		$errorsOccur++;
	} else {
		// Save the state of checked boxes and see how many are checked
		if (in_array('firefox', $_POST['browsers'])) {
		  $firefox = 'checked';
		  $browserCheckedCount++;
		}
		if (in_array('chrome', $_POST['browsers'])) {
		  $chrome = 'checked';
		  $browserCheckedCount++;
		}
		if (in_array('safari', $_POST['browsers'])) {
		  $safari = 'checked';
		  $browserCheckedCount++;
		}

		// Check if at least two browsers are checked
		if ($browserCheckedCount < 2) {
			$browserError = "You MUST select at least two favorite browsers";
			$emptyCheck = 1;
			$errorsOccur++;	
		}
	}

	// Validation for dropdown menu
	// Check if radio button is selected for company
	 if (filter_input(INPUT_POST, 'time_per_day') == '-SELECT AN OPTION-') {
		$timePerDayError = "Please select a time from the dropdown";
		$emptyCheck = 1;
		$errorsOccur++;
	} else {
		// See which field was selected for saving the state
		$timePerDayField = $_POST['time_per_day'];
		if($timePerDayField == "1-2 Hours") {
			$firstOption = 'selected';
		} elseif($timePerDayField == "2-10 Hours") {
			$secondOption = 'selected';
		} elseif($timePerDayField == "FOREVERRRR") {
			$thirdOption = 'selected';
		} 
	}

	// Validation for email check and email field
	if(!empty($_POST['email_check'])) {
		// We know the email is checked so check validation on email text field
		$emailChecked = 1;
	}

	// Check if email field is empty and write error if box is checked
	if(empty($emailField)) {
		$emailEmpty = 1;
		if($emailChecked == 1) {
			$emailCheckError = "You must enter an email or uncheck the send email box";
			$emptyCheck = 1;
			$errorsOccur++;	
		}
	} else {
		// Check if not valid and write an error only if the toggle is checked
		if($emailChecked == 1) {
			if (!filter_var($emailField, FILTER_VALIDATE_EMAIL)) {
				$emailError = "Please enter a valid email or uncheck above box";
				$errorsOccur++;	
				$emailField = "";
			}
		}	
	}

	// If validation does not pass
	if ($errorsOccur > 0) {
		$errorsOnPage = "There are {$errorsOccur} error(s) on the page";
		if($emptyCheck == 1) {
			$someEmptyError = "You MUST fill out every field except email and email checkbox";
		}
	} else { // Validation passes
		// Unhide results area and display results
		$displayNone = 'style="display:none"';
		$resultsView = "";
		$fullyValidated = 1;

		// Appened or save to file
		$file = "surveyResults.txt"; 
		// Create for the results above
		$content = "Internet Survey Submission\n";
		$content .= "Name: {$nameField}\n";
		$content .= "Internet Likes: {$likeField}\n";
		$content .= "Favorite Company: {$companyField}\n";

		// Create list of browsers
		$browser = "";
		if(!empty($chrome)) {
			$browser .= "Chrome ";
		}
		if(!empty($firefox)) {
			$browser .= "Firefox ";
		}
		if(!empty($safari)) {
			$browser .= "Safari ";
		}
		$content .= "Favorite Browsers: {$browser}\n";
		// Time spent per day field
		$content .= "Time Spent On Internet Per Day: {$timePerDayField}\n";

		// Check to display message that an email was sent
		if($emailChecked == 1) {
			$content .= "Email sent to {$emailField} with results\n";
		}

		// Save email content before adding divider
		$emailContent = $content;
		// End divider for file
		$content .= "---------------------------------------------------\n\n";

		// Write contents to file, append if already data inside, and lock file from being changed while writing
		file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
		// Make sure it is readable by all users
		chmod($file, 0644);

		// Check if we need to send an email
		if($emailChecked == 1) {
			$subject = 'Internet Survey Results';
			$message = "Here are your internet survey results!\n\n";
			$message .= $emailContent;

			// Send the mail
			mail($emailField, $subject, $message);
		}
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
	<h1> INFX 2670 Assignment 1 - Michael Northorp </h1>
	<div id="form">
		<form method="post" <?php echo $displayNone ?>>
			<h1> Internet is Awesome Survey </h1>

			<div id="name" <?php if(!empty($nameError)) { echo 'class="errorOutline"'; } ?>>
				<p>Name</p>
				<input type="text" name="name_field" size=20 value="<?php echo $nameField ?>"><br>
				<span class="error"><?php echo $nameError ?></span><br>
			</div>

			<div id="likes" <?php if(!empty($likeError)) { echo 'class="errorOutline"'; } ?>>
				<p>Write why you like the internet</p>
				<textarea name="like_field" cols=40 rows=5><?php echo $likeField ?></textarea><br> 
				<span class="error"><?php echo $likeError ?></span>
			</div>

			<div id="company" <?php if(!empty($companyError)) { echo 'class="errorOutline"'; } ?>>
				<p>Pick your favorite</p>
				<input type="radio" name="companies" value="Google" <?php echo $google ?>> Google<br>
				<input type="radio" name="companies" value="Microsoft" <?php echo $microsoft ?>> Microsoft<br>
				<input type="radio" name="companies" value="Apple" <?php echo $apple ?>> Apple<br>
				<span class="error"><?php echo $companyError ?></span><br>
			</div>

			<div id="browser" <?php if(!empty($browserError)) { echo 'class="errorOutline"'; } ?>>
				<p>Pick at least two favorite browsers</p>
				<input type="checkbox" name="browsers[]" value="chrome" <?php echo $chrome ?>> Chrome<br>
				<input type="checkbox" name="browsers[]" value="firefox" <?php echo $firefox ?>> Firefox<br>
				<input type="checkbox" name="browsers[]" value="safari" <?php echo $safari ?>> Safari<br>
				<span class="error"><?php echo $browserError ?></span>
			</div>

			<div id="time" <?php if(!empty($timePerDayError)) { echo 'class="errorOutline"'; } ?>>
				<p>How long do you spend on the internet a day?</p>
				<select name="time_per_day">
				  <option name="time_per_day" value="-SELECT AN OPTION-">-SELECT AN OPTION-</option>
				  <option name="time_per_day" value="1-2 Hours" <?php echo $firstOption ?>>1-2 Hours</option>
				  <option name="time_per_day" value="2-10 Hours" <?php echo $secondOption ?>>2-10 Hours</option>
				  <option name="time_per_day" value="FOREVERRRR" <?php echo $thirdOption ?>>FOREVERRRR</option>
				</select>
				<br>
				<span class="error"><?php echo $timePerDayError ?></span>
			</div>

			<div id="email" <?php if(!empty($emailCheckError) || !empty($emailError)) { echo 'class="errorOutline"'; } ?>>
				<p>If you wish to receive the submission as an email, enter email and check box below</p>
				<input type="checkbox" name="email_check" value="send_email" <?php if($emailChecked == 1) { echo "checked"; } ?>> Send Email
				<span class="error"><?php echo $emailCheckError ?></span><br>
				<input type="text" name="email_field" size=20 value="<?php echo $emailField ?>">
				<span class="error"><?php echo $emailError ?></span><br>
			</div>

			<input type="submit" value="Submit" id="btn">
			<br><span class="error"><?php echo $someEmptyError ?></span><br>
			<span class="error"><?php echo $errorsOnPage ?></span>
		</form>
	</div>

	<div id="results" style="<?php echo $resultsView ?>">
		<h1>Internet is Awesome Results</h1>
		<?php if($fullyValidated == 1) : ?>
			<div id="name-result">
				<h3>Name</h3>
				<p><?php echo $nameField ?></p>
			</div>
			<div id="likes-result">
				<h3>Internet Likes</h3>
			 	<p><?php echo $likeField ?></p>
			 </div>
			<div id="company-result">
				<h3>Favorite Company</h3>
				<p><?php echo $companyField ?></p>
			</div>
			<div id="browser-result">
				<h3>Favorite Browsers</h3>
				<ul>
				<?php if(!empty($chrome)) echo "<li>Chrome</li>" ?>
				<?php if(!empty($firefox)) echo "<li>Firefox</li>" ?>
				<?php if(!empty($safari)) echo "<li>Safari</li>" ?>
				</ul>
			</div>
			<div id="time-results">
				<h3> Time Spent On Internet Per Day </h3>
				<p><?php echo $timePerDayField ?></p>
			</div>
			<?php if($emailChecked == 1) : ?>
			<div id="email-results">
				<p>Email sent to <?php echo $emailField ?> with results</p>
			</div>
			<div id="file-results">
				<p>File saved to /surveyResults.txt</p>
			</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>

</body>
</html>