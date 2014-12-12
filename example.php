<?php
use Bracket\BracketDB as DB;
include('bracketdb/Bracket.php');


$table = DB::table('users');
$user = DB::table('users')->where('id', '=', '1')->first();


?>
<html>
<head>
	<title>Bracket</title>
</head>
<body>
	<table border=1>
		<tr>
			<?php foreach($table->structure() as $s) { echo "<th>$s</th>"; } ?>
		</tr>
		<?php
		foreach($table->get() as $user) {
			echo "<tr>";
			foreach($user as $key => $value) {
				echo "<td>$value</td>";
			}
			echo "</tr>";
		}
		?>
	</table>
</body>
</html>
