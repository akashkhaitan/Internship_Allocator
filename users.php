<?
//$username = $_COOKIE['username'];
//$password = $_COOKIE['password'];
$sid = $_COOKIE['sid'];
$stutable=$_COOKIE['stutable'];
echo "Hello ".$sid;
echo "<p><a href=logout.php>Logout</a></p>";
mysql_connect("localhost", "dummy", "dummy") or die(mysql_error());
mysql_select_db("internship") or die(mysql_error());
//echo $stutable;
$result=mysql_query("SELECT * FROM $stutable where sid='$sid'");
while($row=mysql_fetch_assoc($result))
{
	$sname=$row['sname'];
	$sip=$row['sip'];
	$sipyr=$row['sipyr'];
}
$comtable=$sipyr."ip".$sip;
$preftable=$sipyr."pref".$sip;

$result = mysql_query("SELECT * FROM $comtable");
if(isset($_POST['submit']))
{
	$i=0;
	$m=0;
	while($row=mysql_fetch_assoc($result))
	{
		$cname=$row['cname'];
		$pref=$_POST['name'][$i];
		$result1 = mysql_list_tables("internship");
		$num_rows = mysql_num_rows($result1);
		for ($j = 0; $j < $num_rows; $j++) 
		{
		    //echo "Table:".mysql_tablename($result, $i)."\n";
		    $str=mysql_tablename($result1, $j);
		    if($str==$preftable)
		    {
		    	$m=1;
		    	break;
		    }	    
		}
		if($m==0)
		{
			mysql_query("CREATE TABLE `$preftable` (
					`sid` varchar(11) NOT NULL,
					`cname` varchar(50) NOT NULL,
					`pref` int NOT NULL)");
		$m=1;
		}
		if($m==1)
		{			
			$add_company=mysql_query("INSERT INTO $preftable values('$sid','$cname','$pref')");
			//echo "Submitted";
		}
	 	$common = mysql_query("INSERT INTO common (id,cname,pref) VALUES ('$sid', '$cname', '$pref')");
		$i=$i+1;
	}
	echo "Added";
}
else
{
echo "Here are the list of companies , please fill your prefrences";
echo "<Table border=\"1\">";
echo '<html><form action="users.php" method="post"></html>';
while($row=mysql_fetch_assoc($result))
{
	echo "<tr>";
    	echo "<td>".$row['cname']."</td>";
    	echo "<td><input type=\"text\" name=\"name[]\"></td>";
    	echo "</tr>";
}
echo '<html><tr><td colspan="2" align="right">
            <input type="submit" name="submit" value="Submit">
        </td>
    </tr></form></html>';
}
?>
