<?php
use Bracket\BracketDB as DB;
include('bracketdb/Bracket.php');

$table = DB::table('users');
$table->where('id', '=',  '1')->first()->name="New name";
$table->save();
?>
<html>
<head>
	<title>Bracket</title>
</head>
<body>
	<table border=1>
		<tr>
			<?php foreach(DB::table('users')->structure() as $s) { echo "<th>$s</th>"; } ?>
		</tr>
		<?php
		foreach(DB::table('users')->get() as $user) {
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
