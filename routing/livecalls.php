<?php
$username = "root";
$password = "r5dh@t";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)or die("Unable to connect to MySQL");
$selected = mysql_select_db("livecalls",$dbhandle) or die("Could not select examples");
echo "Connected to MySQL<br>";
$query = "SELECT channels.created,channels.dest,channels.cid_num,TIMEDIFF(time(now()),time(channels.created))as Duration,dids_users.superresseler_id,dids_users.resseller_id,numberranges.name, dids_users.subresseller_id FROM livecalls.dids
                INNER JOIN livecalls.dids_users ON (dids.id = dids_users.did_id)
                inner join numberranges on numberranges.id=dids.numberrange_id
                INNER JOIN livecalls.channels ON (channels.dest = dids.did) where dids.IsTestNumber=0  ORDER BY channels.created DESC;";
//$result = mysql_query($query);
$result=mysql_unbuffered_query($query);
//fetch tha data from the database
echo "<table border='1'><tr><td>Number Range</td><td>Called Number</td><td>Duration</td><td>Calling Number</td></tr>";
while ($row = mysql_fetch_array($result)) {
   echo "<tr>";
   echo "<td>".$row['name']."</td>";
   echo "<td>".$row['dest']."</td>";
   echo "<td>".$row['cid_num']."</td>";
   echo "<td>".$row['Duration']."</td>";
   echo "</tr>";
}
echo "</table>";
?>
