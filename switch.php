<!DOCTYPE html>
<html>
	<head>
		<title>switch</title>
	</head>
	<body>
		<table border="0">
			<tr>
				<td><a href="./switch.php?act=on">ON</a></td>
				<td>&nbsp;</td><!-- it means a space, it's a html entity. -->
				<td><a href="./switch.php?act=off">OFF</a></td>
				<td>&nbsp;</td>
				<td><a href="./switch.php?act=change">Toggle</a></td>
				<td>&nbsp;</td>
				<td><a href="./switch.php">Status</a></td>
				<td>&nbsp;</td>
				<td><a href="./switch.php?act=reload">Auto Update</a></td>
			</tr>
		</table>
		<?php 
			$file = getcwd() . "/file";
			$content = json_decode(file_get_contents($file), TRUE);
			if (count($_GET) == 0) {
				if ($content == "on") {
					echo "<img src=" . "./bulb_on.jpg" . ">";
				}
				else{
					echo "<img src=" . "./bulb_off.jpg" . ">";
				}
			}
			else {
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "myDB";
				$conn = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
				if (!$conn) {
				    die("Connection failed: " . mysqli_connect_error());
				}
				if ($_GET['act'] == "on") {
					echo "<img src=" . "./bulb_on.jpg" . ">";
					$content = json_encode("on");
					file_put_contents($file, $content);
					$sql = "INSERT INTO Events(event) VALUES('on')";
					if (mysqli_query($conn, $sql)) {
						$last_id = mysqli_insert_id($conn);
				    echo "New record created successfully. Last inserted ID is: " . $last_id;
					} else {
					    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
				}
				elseif ($_GET['act'] == "off") {
					echo "<img src=" . "./bulb_off.jpg" . ">";
					$content = json_encode("off");
					file_put_contents($file, $content);
					$sql = "INSERT INTO Events(event) VALUES('off')";
					if (mysqli_query($conn, $sql)) {
						$last_id = mysqli_insert_id($conn);
				    echo "New record created successfully. Last inserted ID is: " . $last_id;
					} else {
					    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
				}
				elseif ($_GET['act'] == "change") {
					if ($content == "on") {
						echo "<img src=" . "./bulb_off.jpg" . ">";
						$content = json_encode("off");
					}
					else {
						echo "<img src=" . "./bulb_on.jpg" . ">";
						$content = json_encode("on");
					}
					file_put_contents($file, $content);
					$sql = "INSERT INTO Events(event) VALUES('change')";
					if (mysqli_query($conn, $sql)) {
						$last_id = mysqli_insert_id($conn);
				    echo "New record created successfully. Last inserted ID is: " . $last_id;
					} else {
					    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
				}
				elseif ($_GET['act'] == "reload") {
					if ($content == "on") {
						echo "<img src=" . "./bulb_on.jpg" . ">";
					}
					else {
						echo "<img src=" . "./bulb_off.jpg" . ">";
					}
					header("Refresh:0.5");
				}
			}
			echo "<br>";
			print_r($GLOBALS);
		?>
	</body>
</html>
