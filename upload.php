<?php include 'header.php'; ?>

<?php
function uploadPortfolioFile($file){
	$allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
	$maxSize = 2 * 1024 * 1024;

	if ($file['error'] !== 0) {
		throw new Exception("Upload error");
	}

	if (!in_array($file['type'], $allowedTypes)) {
		throw new Exception("Invalid file type");
	}

	if ($file['size'] > $maxSize) {
		throw new Exception("File too large");
	}

	$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
	$newName = "portfolio_" . time() . "." . $ext;

	if (!is_dir("uploads")) {
		throw new Exception("Uploads folder missing");
	}

	move_uploaded_file($file['tmp_name'], "uploads/" . $newName);
	return $newName;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	try {
		$fileName = uploadPortfolioFile($_FILES['portfolio']);
		$success = "File uploaded: $fileName";
	} catch (Exception $e) {
		$error = $e->getMessage();
	}
}
?>

<h2>Upload Portfolio</h2>

<?php
if ($error) echo "<p style='color:red;'>$error</p>";
if ($success) echo "<p style='color:green;'>$success</p>";
?>

<form method="post" enctype="multipart/form-data">
	<input type="file" name="portfolio">
	<button type="submit">Upload</button>
</form>

<?php include 'footer.php'; ?>
