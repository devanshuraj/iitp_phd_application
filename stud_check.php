<?php 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
$mailhost = $_POST["selected_server"];
$user     = $_POST["user_login"];
$passwd   = $_POST["user_password"];

if(preg_match('(praveenk|pic_guest|guest_off|pic_auto|1801cs19)', $user) === 1) {
	// $pop = imap_open('{' .$mailhost. '}', $user, $passwd);

	#$pop  = imap_open("{172.16.1.222:995/pop3/ssl/novalidate-cert}" , $user, $passwd);
	$pop = true;
	if ($pop == false) 
	{
		echo "<center>Authentication Failed</center>\n";
	} 
	else 
	{
				// imap_close($pop);

		echo '<table align="right">
		<tr>
		<td><table align="right" border = 8><tr><td><a href="logout.php">LOGOUT</a></td></tr></table>
		</table>';
			include ("encrypt.php");

					$access   = 1;
					$_SESSION['access']=encrypt_decrypt('encrypt', $access);
						header("location: admin.php");
	}
}
else
	echo "<center><b>You are Not Admin</b></center>";
?>



