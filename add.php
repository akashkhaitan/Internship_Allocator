<?php
// Connects to your Database
mysql_connect("localhost", "dummy", "dummy") or die(mysql_error());
mysql_select_db("internship") or die(mysql_error());

//if the login form is submitted
if (isset($_POST['submit']))
{
    //This makes sure they did not leave any fields blank
    if (!$_POST['username'] | !$_POST['password'] | !$_POST['cpassword'] )
    {
        die('You did not complete all of the required fields');
    }
    
    // checks if the username is in use
    $username = $_POST['username'];
    $table = mysql_query("SELECT username FROM login WHERE username = '$username'") or die(mysql_error());
    $check = mysql_num_rows($table);
    
    //if the name exists it gives an error
    if ($check != 0)
    {
        die('Sorry, the username '.$_POST['username'].' is already in use.');
    }
    
    // this makes sure both passwords entered match
    if ($_POST['password'] != $_POST['cpassword'])
    {
        die('Your passwords did not match. ');
    }
    
    // here we encrypt the password
    $password = md5($_POST['password']);
    
    // now we insert it into the database    
    $add_member = mysql_query("INSERT INTO login (username, password) VALUES ('$username', '$password')");
?>

<h1>Registered</h1>
<p>Thank you, you have registered - you may now <a href="login.php">login</a>.</p>

<?php
}
else
{
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table>
    <tr>
        <td>Username:</td>
        <td>
            <input type="text" name="username">
         </td>
    </tr>
    <tr>
        <td>Password:</td>
        <td>
            <input type="password" name="password" maxlength="10">
        </td>
    </tr>
    <tr>
        <td>Confirm Password:</td>
        <td>
            <input type="password" name="cpassword">
        </td>
    </tr>
    <tr>
        <th colspan=2>
            <input type="submit" name="submit" value="Register">
        </th>
    </tr>
</table>
</form>

<?php
}
?>
