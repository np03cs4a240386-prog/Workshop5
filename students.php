<?php include 'header.php'; ?>

<h2>Student List</h2>

<?php
if (!file_exists("students.txt")) {
	echo "<p>No students found</p>";
} else {
	$lines = file("students.txt");

	foreach ($lines as $line) {
		list($namePart, $emailPart, $skillsPart) = explode("|", $line);

		$name = explode(":", $namePart)[1];
		$email = explode(":", $emailPart)[1];
		$skills = explode(",", explode(":", $skillsPart)[1]);

		echo "<p>";
		echo "<strong>Name:</strong> $name<br>";
		echo "<strong>Email:</strong> $email<br>";
		echo "<strong>Skills:</strong> ";
		print_r($skills);
		echo "</p><hr>";
	}
}
?>

<?php include 'footer.php'; ?>
