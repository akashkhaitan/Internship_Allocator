<?php

//checks cookies to make sure they are logged in
if(isset($_COOKIE['username']))
{
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    
    // Connects to your Database
    mysql_connect("localhost", "dummy", "dummy") or die(mysql_error());
    mysql_select_db("test") or die(mysql_error());
    
    $table = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error());
    
    while($trow = mysql_fetch_array( $table ))
    {
        //if the cookie has the wrong password, they are taken to the logout page
        if ($password != $trow['password'])
        {
            header("Location: logout.php");
        }
        
        //otherwise they are shown the member area        
        else
        {
        	if($username=="administrator")
		{
			header("Location: administrator.php");
		}
		else
		header("Location: users.php");
            //echo "Hello ".$username;
            //echo "<p><a href=logout.php>Logout</a></p>";
        }
    }
}
else
//if the cookie does not exist, they are taken to the login screen
{
    header("Location: login.php");
}
?> 
