<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Internet is Awesome</title>
</head>
<body>
<div id="content">
	<h1> INFX 2670 Assignment 1 - Mike Northorp </h1>
	<div id="form">
		<form method="post">
			<h1> Internet is Awesome Survey </h1>
			<p>Name:</p><input type="text" name="text_field" size=20> <br>

			<p>Write why you like the internet</p><textarea name="text_area" cols=40 rows=8></textarea> <br>

			<p>Pick your favorite</p><br>
			<input type="radio" name="" value="Google"> Google<br>
			<input type="radio" name="radio1" value="Microsoft"> Microsoft<br>
			<input type="radio" name="radio1" value="Apple"> Apple<br>
			
			<p>Pick top two favorite browsers</p><br>
			<input type="checkbox" name="option1" value="Milk"> Chrome<br>
			<input type="checkbox" name="option2" value="Butter"> Firefox<br>
			<input type="checkbox" name="option3" value="Cheese"> Safari<br>

			<p>How long do you spend on the internet a day?</p>
			<select>
			  <option value="volvo">2-10 Hours</option>
			  <option value="saab">1-2 Hours</option>
			  <option value="mercedes">FOREVERRRR</option>
			</select>

			<p>If you wish to receive the submission as an email, enter email and check box below</p>
			<div id="email_toggle">
				<input type="checkbox" name="option1" value="send_email"> Send Email<br>
				<input type="text" name="text_field" size=20> <br>
			</div>

			<input type="submit" value="Submit">
		</form>
	</div>

	<div id="results" style="display:none">
		<h1>Results</h1>
	</div>
</div>

</body>
</html>