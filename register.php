<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 
        Bootstrap CSS
     -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.
min.css" rel="stylesheet" integrity="sha384-EVSTQN3/
azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
crossorigin="anonymous">
    <!-- 
         10/21/21 Register Users- Using the index.html as basic layout,
         need to incorporate the php scripts from the register.php file that works!
		10/21/21 10AM - adding the CSS styles from index page.
    -->
<title>New User Registration</title>
<style>

* {
     box-sizing: border-box;
 }
 
 body {
     margin: 0;
     padding: 0px;
 }

 #layout {
     display: flex;
     flex-wrap: wrap;
 }
 /* Style the div id's */
 
 #nav {
     flex-basis: 100%;
     border-bottom: 5px solid #b39f00;
     padding: 20px;
     background-color: #7d6f00;
     /*   column-count: 6; */
 }
 
 #sidebar {
     flex-basis: 20%;
     border: 5px solid #7d6f00;
     padding: 15px;
     background-color: rgb(38, 82, 82);
 }
 
 #content {
     flex-basis: 80%;
     border: 5px solid #94b300;
     padding: 20px;
     background-color: #b39f00;
     /* text: color #7d5600; Figure out a color!*/
 }

 .button {
     padding: 5px;
     margin: 5px;
     flex-basis: 10%;
     position: sticky;
     position: relative;
     /*   display: inline-block; */
 }
 
 a {
     background-color: rgb(38, 82, 82);
     display: inline-block;
     padding: 5px 15px;
     color: cornflowerblue;
     text-decoration: none;
     border: 2px solid #94b300;
     transition: background-color 0.5s, padding 1s;
 }
 
 a:hover {
     background-color: #b39f00;
     color: azure;
     padding: 10px 20px;
 }
 /* For mobile devices */
 
 @media (max-width: 640px) {
     #sidebar #content {
         flex-basis: 100%;
         border-right: 0;
	 }
     
     /* For very small mobile devices */
     @media (max-width: 475px) {
         #sidebar {
             display: none;
         }
         
		
	}

 }
</style>
</head>

<body>
 
<div id="layout">
     <div id="nav">
         <a href="index.html" class="button">Home</a>
         <!-- <a href="register.html" class="button">Register</a> -->
         <a href="#" class="button">Login</a>
         <a href="#" class="button">Button4</a>
         <a href="#" class="button">Button5</a>
         <a href="#" class="button">Button6</a>
     </div>
     <div id="sidebar">
         Welcome!
     </div>



<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

//$page_title = 'Register';
//include('includes/header.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('mysqli_connect.php'); // Connect to the db.

	$errors = []; // Initialize an error array.

	// Check for a first name:
	if (empty($_POST['firstname'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
	}

	// Check for a last name:
	if (empty($_POST['lastname'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}

	if (empty($errors)) { // If everything's OK.

		// Register the user in the database...

		// Make the query:
		$q = "INSERT INTO user (firstname, lastname, email, password, date_time) VALUES ('$fn', '$ln', '$e', SHA2('$p', 512), NOW() )";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>You are now registered. In Chapter 12 you will actually be able to log in!</p><p><br></p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';

		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include('includes/footer.html');
		exit();

	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';

	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
	<div id="content">
<h1>Register</h1>
<form action="register.php" method="post">
	<p>First Name: <input type="text" name="firstname" size="15" maxlength="20" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>"></p>
	<p>Last Name: <input type="text" name="lastname" size="15" maxlength="40" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>"></p>
	<p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" > </p>
	<p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" ></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p>
	<p><input type="submit" name="submit" value="Register"></p>
</form>
 <!-- include('includes/footer.html');  -->
 </div>



</body>
 
</html>