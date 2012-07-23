
<?php
// Connects to your Database
mysql_connect("localhost", "dummy", "dummy") or die(mysql_error());
mysql_select_db("internship") or die(mysql_error());

//Checks if there is a login cookie
if(isset($_COOKIE['username']))
//if there is, it logs you in and directes you to the members page
{
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    $table = mysql_query("SELECT * FROM login WHERE username = '$username'")or die(mysql_error());
    while($trow = mysql_fetch_array( $table ))
    {
        if ($password == $trow['password'])
        {
            header("Location: member.php");
        }
    }
}

//if the login form is submitted
if (isset($_POST['submit']))
{
    // makes sure they filled it in
    if(!isset($_POST['username']) | !isset($_POST['password']))
    {
        die('You did not fill in a required field.');
    }
  
    $table = mysql_query("SELECT * FROM login WHERE username = '".$_POST['username']."'")or die(mysql_error());
    
    //Gives error if user dosen't exist
    $check = mysql_num_rows($table);
    if ($check == 0)
    {
        die('That user does not exist in our database. <a href=add.php>Click Here to Register</a>');
    }
    while($trow = mysql_fetch_array( $table ))
    {
        $password = md5($_POST['password']);
        
        //gives error if the password is wrong
        if ($password != $trow['password'])
        {
        	echo $password;
            die('Incorrect password, please try again.');
        }
        else
        {
            // if login is ok then we add a cookie
            $hour = time() + 3600;
            setcookie(username, $_POST['username'], $hour);
            setcookie(password, $password, $hour);
            //then redirect them to the members area
            header("Location: member.php");
        }
    }
}
//Student Form
if (isset($_POST['stusub']))
{
    // makes sure they filled it in
    if(!$_POST['sid'])
    {
        die('You did not fill in a required field.');
    }
    $sid=$_POST['sid'];
    //echo $sid;
     $id=(int)$sid;
     $stutable=$id."batch";
     $table = mysql_query("SELECT * FROM $stutable WHERE sid = '$sid'")or die(mysql_error());
    //Gives error if user dosen't exist
    $check = mysql_num_rows($table);
    if ($check == 0)
    {
        die('Your Id doesnt exist , contact ip administrator');
    }
    $hour = time() + 3600;
    //$hour1=time()+1;
    setcookie(sid, $sid, $hour);
    setcookie(stutable, $stutable, $hour);
     header("Location: users.php");
 }
else
{
    // if they are not logged in
?>
<h1>Internship Allocator</h1>
<table align=center width=100%>
<tr>
<td>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table align="left">
    <tr>
        <td colspan=2>
            <h2>Admin Login</h2>
        </td>
    </tr>
    <tr>
        <td>Username:</td>
        <td>
            <input type="text" name="username">
        </td>
    </tr>
    <tr>
        <td>Password:</td>
        <td>
            <input type="password" name="password">
        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">
            <input type="submit" name="submit" value="Login">
        </td>
    </tr>
</table>
</td>
<td>
<table align="right">
    <tr>
        <td colspan=2>
            <h2>Student's Login</h2>
        </td>
    </tr>
    <tr>
        <td>Id:</td>
        <td>
            <input type="text" name="sid">
        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">
            <input type="submit" name="stusub" value="Login">
        </td>
    </tr>
</table>
</td>
</tr>
</table>
</form>
<?php
}
?> 
