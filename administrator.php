<head>
<style type="text/css">
#container  {
width: 100%;

}

#header	{

width: 100%;
height: 100px;
position: relative;
background-color:#b0c4de;
border-bottom: 2px solid #000000;

}

#header a  
{

color: #ffffff;
text-decoration: underline;
font-weight: bold;
font-family: Verdana;
font-size: 14px;

}

#header a:visited  {

color: #000000;
text-decoration: underline;
font-weight: bold;

}

#header a:hover  {

color: #cc0000;
text-decoration: none;
font-weight: bold;

}


.HorizLinks  {

position: absolute; top: 77px; left: 180px; 

}

.HorizLinks ul { 

margin: 0px; 

}

.HorizLinks li {

margin: 0px 15px 0px 0px;
list-style-type: none;
display: inline;
	
}


#horizontalnav  {

width: 900px;
height: 30px;
position: relative;
background-color: #F2D6AF;
border-bottom: 2px solid #000000;

}

.navlinks  {

position: absolute; top: 4px; left: 140px; 

}

.navlinks ul { 

margin: auto;

}

.navlinks li {

margin: 0px 18px 0px 0px;
list-style-type: none;
display: inline;
	
}

.navlinks li a {

color: #000000;
padding: 5px 12px 7px;
text-decoration: none;
font-size: 16px;
font-family: Verdana;

}

.navlinks li a:hover{

color: #ffffff;
background-image: url(images/BGhover.jpg);
 /*If you want to use a color for the background instead replace above line with background-color: [insert color here with # sign in front];*/
text-decoration: underline;


}


#header p  {

color: #000000;
font-family: Arial;
font-weight: bold;

}

.smalltext   {

font-size: 9px;
font-family: Arial;

}


#leftnav {

float: left;
width: 15%;
height: 100%;
background-color: #8B8878;
border-right: 1px dashed #694717;

}
		

#rightnav  
{

	float: right;
	width: 15%;
	height: 100%;
	background-color: #8B8878;
	border-left: 1px dashed #694717;
}

#body  
{
	margin: auto;
	width: 70%;
	//height: 100%;
	//background-color: #8B6508;
	padding: 10% 0px 0px 30%;
}

#footer  {

clear: both;
background-color: #D1C0A7;

}


h2  {
font-size: 20px;
color: #cc0000;
padding: 10px;
font-family: Verdana;
}
h1
{
position: absolute; top: 4px; left: 1px; 
}
</style>
</head>

<?
$username = $_COOKIE['username'];
$password = $_COOKIE['password'];
mysql_connect("localhost", "dummy", "dummy") or die(mysql_error());
mysql_select_db("internship") or die(mysql_error());
echo "<div id=\"container\"><div id=\"header\"><h1>Internship Alocator</h1></div>";
echo "<div id =\"rightnav\"><p>Hello $username</p> <p><a href=logout.php>Logout</a></p></div>";
echo "<div id=\"leftnav\">
<form action=\"administrator.php\"; method=\"POST\">
<input type=\"submit\" name=\"adc\" value=\"Add Companies\">
<p>
<input type=\"submit\" name=\"allot\" value=\"Allot Companies\">
</p>
<p>
<input type=\"submit\" name=\"ads\" value=\"Add Students\">
</p>
<input type=\"submit\" name=\"edc\" value=\"Edit Company\">
</form>
</div>";

/*$result = mysql_query('SELECT * FROM company');
echo "<Table border=\"2\">";
echo "Companies Alredy Added";
echo "<tr><td>Company Name</td><td>Seats</td></tr>";
while ($row = mysql_fetch_assoc($result)) 
{
	echo "<tr>";
    	echo "<td>".$row['name']."</td>";
    	echo "<td>".$row['seats']."</td>";
    	echo "</tr>";
}
echo "</Table>";
	echo "<p><Table border=\"2\">";
	echo "Company Allotment";
	echo "<tr><td>Name</td><td>Company Name</td></tr>";
	$result = mysql_query('SELECT * FROM allotment');
	while ($row = mysql_fetch_assoc($result)) 
	{
		echo "<tr>";
	    	echo "<td>".$row['name']."</td>";
	    	echo "<td>".$row['cname']."</td>";
	    	echo "</tr>";
	}
echo "</Table>";
echo "</p>";*/




if(isset($_POST['submit']))
{
	if(!$_POST['ipn'] | !$_POST['cid'] | !$_POST['name'] | !$_POST['seats'] | !$_POST['ipyr'])
	{
	echo $_POST['name'];
	echo $_POST['seats'];
        	die('You did not complete all of the required fields');
        	//echo "<p><a href='administrator.php'>Go back</a>.</p>";
    	}
 	$ipn=$_POST['ipn'];
 	$cid=$_POST['cid'];
    	$cname = $_POST['name'];
   	$seats=$_POST['seats'];
   	$ipyr=$_POST['ipyr'];
   	$cgpar=$_POST['cgpar'];
   	$branchr=$_POST['branchr'];
   	$clocation=$_POST['location'];
   	$comtable=$ipyr."ip".$ipn;
   	//$add_company = mysql_query("INSERT INTO company (name,seats) VALUES ('$cname', '$seats')");
   	//header("Location: administrator.php");
   	//$st="ram";
	//$str=1;
	//$s=$st.$str;
	//echo $s;
	$m=0;
	$result = mysql_list_tables("internship");
	$num_rows = mysql_num_rows($result);
	for ($i = 0; $i < $num_rows; $i++) 
	{
	    //echo "Table:".mysql_tablename($result, $i)."\n";
	    $str=mysql_tablename($result, $i);
	    if($str==$comtable)
	    {
	    	$m=1;
	    	break;
	    }	    
	}
	if($m==0)
	{
		mysql_query("CREATE TABLE `$comtable` (
					`cid` varchar(11) NOT NULL,
					`cname` varchar(50) NOT NULL,
					`clocation` varchar(255),
					`seats` int NOT NULL,
					`cgpar` int NOT NULL,
					`branchr` varchar(4) NOT NULL)");
		$m=1;
	}
	if($m==1)
	{
		$table = mysql_query("SELECT cid FROM $comtable WHERE cid = '$cid'") or die(mysql_error());
    		$check = mysql_num_rows($table);
    		
    		//if the name exists it gives an error
    		if ($check != 0)
    		{
    		    die('The Company with id '.$_POST['cid']." and name ".$_POST['name']. ' is already present');
    		} 
    		//no. of rows to be calculated in table and c1,c2 to be allcoated
    		
		$add_company=mysql_query("INSERT INTO $comtable values('$cid','$cname','$clocation','$seats','$cgpar','$branchr')");
		echo "Added, To add more Click Add companies";
	}
}





if(isset($_POST['stusub']))
{
    //This makes sure they did not leave any fields blank
    if (!$_POST['sid'] |!$_POST['sname'] | !$_POST['cgpa'] | !$_POST['sip'] | !$_POST['sipyr'])
    {
        die('You did not complete all of the required fields');
    }
    //echo "God is great"; 
    // checks if the username is in use
    $sid = $_POST['sid'];
    $sname=$_POST['sname'];
    $cgpa=$_POST['cgpa'];
    $sip=$_POST['sip'];
    $sipyr=$_POST['sipyr'];
    $id = (int)$sid;
    $stutable=$id."batch";
    echo $stutable;
    $m=0;
    	$result = mysql_list_tables("internship");
   	$num_rows = mysql_num_rows($result);
   	for ($i = 0; $i < $num_rows; $i++) 
   	{
    	    //echo "Table: mysql_tablename($result, $i) "\n";
	    $str=mysql_tablename($result, $i);
	    if($str==$stutable)
	    {
	    	$m=1;
	    	break;
	    }	    
	}
	if($m==0)
	{
		//echo "Akash is mad";
		mysql_query("CREATE TABLE `$stutable` (
						`sid` varchar(11) NOT NULL,
						`sname` varchar(50) NOT NULL,
							`cgpa` float NOT NULL,
							`sip` int NOT NULL,
							`sipyr` int NOT NULL)");
		$m=1;
	}
	if($m==1)
	{	
		//echo "Lord ram is krishna"; 
		$table = mysql_query("SELECT sid FROM $stutable WHERE sid = '$sid'") or die(mysql_error());
    		$check = mysql_num_rows($table);
 
    		//if the name exists it gives an error
    		if ($check != 0)
    		{
    		    echo('The id '.$_POST['sid'].' is already present');
    		}
    		else 
		$add_student=mysql_query("INSERT INTO $stutable values('$sid','$sname','$cgpa','$sip','$sipyr')");
	}
	
	
	//Creating,inserting values in the iptable
	$iptable=$sipyr."students".$sip;
	$n=0;
	$result1 = mysql_list_tables("internship");
   	$num_rows = mysql_num_rows($result);
   	for ($i = 0; $i < $num_rows; $i++) 
   	{
    	    //echo "Table: mysql_tablename($result, $i) "\n";
	    $str=mysql_tablename($result, $i);
	    if($str==$iptable)
	    {
	    	$n=1;
	    	break;
	    }	    
	}
	if($n==0)
	{
		mysql_query("CREATE TABLE `$iptable` (`sid` varchar(11) NOT NULL,`sname` varchar(50) NOT NULL,
							`cgpa` float NOT NULL)");
		$n=1;
	}
	if($n==1)
	{	
		//echo "Lord ram is krishna"; 
		$table1 = mysql_query("SELECT sid FROM $iptable WHERE sid = '$sid'") or die(mysql_error());
    		$check1 = mysql_num_rows($table1);
 
    		//if the name exists it gives an error
    		if ($check1 != 0)
    		{
    		    die('The id '.$_POST['sid'].' is already present');
    		} 
		$add_student=mysql_query("INSERT INTO $iptable values('$sid','$sname','$cgpa')");
	}
    //header("Location: administrator.php");
}




if(isset($_POST['adc']))
{
?>
	<div id="body">
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<table>
	<tr>
	<td>Internship Type*</td>
	<td>
	<input type="radio" name="ipn" value=1> Internship 1<br>
	<input type="radio" name="ipn" value=2> Internship 2<br>
	<input type="radio" name="ipn" value=3> Internship 3<br>
	<td>
	</tr>
	<tr>
       	 <td>Company Id*:</td>
      	  <td>
            <input type="text" name="cid">
         </td>
    </tr>
    	<tr>
       	 <td>Company name*:</td>
      	  <td>
            <input type="text" name="name">
         </td>
    </tr>
    <tr>
       	 <td>Company Location:</td>
      	  <td>
            <input type="text" name="location">
         </td>
    </tr>
    <tr>
        <td>Seats*:</td>
        <td>
            <input type="text" name="seats">
        </td>
    </tr>
    <tr>
    <td>Cgpa Requirements:</td>
    <td>
    	<select name="cgpar">
  	<option value=4>All above Acc</option>
  	<option value=5>5 & Above</option>
  	<option value=6>6 & Above</option>
  	<option value=7>7 & Above</option>
  	<option value=8>8 & Above</option>
  	<option value=9>9 & Above</option>
	</select></td></tr>
    <tr>
    <td>Branch Requirements:</td>
    <td>
    	<select name="branchr">
  	<option value="All">All branches</option>
  	<option value="CS">CS</option>
  	<option value="EC">EC</option>
  	<option value="ME">ME</option>
  	<option value="CI">CI</option>
  	<option value="BT">BT</option>
	</select></td></tr>
	<tr>
    <td>Internship year*:</td>
    <td>
    	<select name="ipyr">
  	<option value=2011>2011</option>
  	<option value=2012>2012</option>
  	<option value=2013>2013</option>
  	<option value=2014>2014</option>
  	<option value=2015>2015</option>
	</select></td></tr>
	
    <tr>
        <th colspan=2>
            <input type="submit" name="submit" value="Register">
        </th>
    </tr>
</table>
</form>
</div>
<?
}




if(isset($_POST['ads']))
{
?>
<div id="body">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table>
	<tr>
        <td>Student Id*:</td>
        <td>
        <input type="text" name="sid">
        </td>
   	 </tr>
    	<tr>
       	 <td>Student name*:</td>
      	  <td>
            <input type="text" name="sname">
         </td>
    </tr>
    <tr>
         <td>CGPA*:</td>
        <td>
            <input type="text" name="cgpa">
        </td>
    </tr>
        <tr>
        <td>IP Type*:</td>
        <td>
         <select name="sip">
  	<option value=1>IP 1</option>
  	<option value=2>IP 2</option>
  	<option value=3>IP 3</option>
  	<option value=0>Cannot be aloc</option>
	</select></td></tr>
        </td>
    </tr>
    <tr>
       <td>Internship year*:</td>
    <td>
    	<select name="sipyr">
  	<option value=2011>2011</option>
  	<option value=2012>2012</option>
  	<option value=2013>2013</option>
  	<option value=2014>2014</option>
  	<option value=2015>2015</option>
	</select></td></tr>
    </tr>
    <tr>
        <th colspan=2>
            <input type="submit" name="stusub" value="Register">
        </th>
    </tr>
</table>
</form>
</div>
<?
	//$str = "06DDCS547";
	//$num = (int)$str;
	//echo $num;
}





if(isset($_POST['allot']))
{
?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<tr>
        <td>IP Type*:</td>
        <td>
        <select name="alip">
  	<option value=1>IP 1</option>
  	<option value=2>IP 2</option>
  	<option value=3>IP 3</option>
	</select></td></tr>
        </td>
       <td>Internship year*:</td>
    <td>
    	<select name="alyr">
  	<option value=2011>2011</option>
  	<option value=2012>2012</option>
  	<option value=2013>2013</option>
  	<option value=2014>2014</option>
  	<option value=2015>2015</option>
	</select></td>
	<th colspan=2>
            <input type="submit" name="allotment" value="Allot">
        </th>
	</tr>
<?	
}





?>
<?	
if(isset($_POST['allotment']))
{
	$alip=$_POST['alip'];
	$alyr=$_POST['alyr'];
	$comtable=$alyr."ip".$alip;
	$preftable=$alyr."pref".$alip;
	$iptable=$alyr."students".$alip;
	$allotable=$alyr."allotment".$alip;
	$name1='Ram';
	$result1= mysql_query("select $iptable.sname,cname,pref from $preftable,$iptable where $preftable.sid = $iptable.sid order by cgpa DESC,pref ASC");
	while($trow = mysql_fetch_array( $result1 ))
	{
		$cname=$trow['cname'];
		$name=$trow['sname'];
		//echo $name."     ";
		//echo $name1."          ";
		if($name!=$name1)
		{
			$flag=0;
		}
		$name1=$name;
		//echo $flag;
		$table = mysql_query("SELECT * FROM $comtable WHERE cname = '$cname'")or die(mysql_error());
    		while($trow1 = mysql_fetch_array( $table ))
    		{
    			$seats=$trow1['seats'];
    			if($seats==0 || ($seats!=0 && $flag==1))
    			{
    				break;
    			}
    			if($seats!=0 && $flag==0)
    			{
    				//echo "Akash";
    				$flag=1;
    				$seats=$seats-1;
    				mysql_query("UPDATE $comtable SET seats=$seats WHERE cname='$cname'");
    				
    				
    				$m=0;
				$result2 = mysql_list_tables("internship");
				$num_rows = mysql_num_rows($result2);
				for ($i = 0; $i < $num_rows; $i++) 
				{
	 			   //echo "Table:".mysql_tablename($result, $i)."\n";
	 			   $str=mysql_tablename($result2, $i);
	 			   if($str==$allotable)
	 			   {
	    				$m=1;
	    				break;
	    			   }	    
				}
				if($m==0)
				{
					//echo "God is great";
					mysql_query("CREATE TABLE `$allotable` (
							`sname` varchar(50) NOT NULL,
							`cname` varchar(50) NOT NULL)");
					$m=1;
				}
				if($m==1)
				{
					
					$ins=mysql_query("INSERT INTO $allotable values	('$name','$cname')");
					//echo "Added, To add more Click Add companies";
				}
    				
    				//$ins=mysql_query("INSERT INTO allotment (name,cname) VALUES ('$name', '$cname')");
    			}
    			
    		}
    		//header("Location: administrator.php");
    	}	
	echo "<p><Table border=\"2\">";
	echo "Company Allotment";
	echo "<tr><td>Name</td><td>Company Name</td></tr>";
	$result = mysql_query("SELECT * FROM $allotable");
	while ($row = mysql_fetch_assoc($result)) 
	{
		echo "<tr>";
	    	echo "<td>".$row['sname']."</td>";
	    	echo "<td>".$row['cname']."</td>";
	    	echo "</tr>";
	}
	echo "</Table>";
	echo "</p>";
	

}



?>

<body>
<div id="footer">
<div class="smalltext">Ajay-anant products
</div>
</body>

