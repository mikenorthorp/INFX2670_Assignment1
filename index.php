<!DOCTYPE html>
<html>
<head>
	<title>Internet is Awesome</title>
</head>
<body>
<div id="content">
	<h1> INFX 2670 Assignment 1 - Mike Northorp </h1>
	<div id="form">
		<form>
			<h1> Internet is Awesome Survey </h1>
			<input type="text" name="text_field" size=20> <br>

			<textarea name="text_area" cols=40 rows=8></textarea> <br>

			<input type="radio" name="radio1" value="Milk"> Milk<br>
			<input type="radio" name="radio1" value="Butter"> Butter<br>
			<input type="radio" name="radio1" value="Cheese"> Cheese<br>
			
			<input type="checkbox" name="option1" value="Milk"> Milk<br>
			<input type="checkbox" name="option2" value="Butter"> Butter<br>
			<input type="checkbox" name="option3" value="Cheese"> Cheese<br>

			<select>
			  <option value="volvo">Volvo</option>
			  <option value="saab">Saab</option>
			  <option value="mercedes">Mercedes</option>
			</select>

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