<?php include 'header.php'; ?>

<?php
function formatName($name){
    return ucwords(trim($name));
}

function validateEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function cleanSkills($string){
    $skills = explode(",", $string);
    return array_map("trim", $skills);
}

function saveStudent($name, $email, $skillsArray){
    $data = "Name:$name|Email:$email|Skills:" . implode(",", $skillsArray) . PHP_EOL;
    $file = fopen("students.txt", "a");
    if (!$file) {
        throw new Exception("File error");
    }
    fwrite($file, $data);
    fclose($file);
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $name = formatName($_POST['name'] ?? '');
        $email = $_POST['email'] ?? '';
        $skillsInput = $_POST['skills'] ?? '';

        if (empty($name) || empty($email) || empty($skillsInput)) {
            throw new Exception("All fields required");
        }

        if (!validateEmail($email)) {
            throw new Exception("Invalid email");
        }

        $skillsArray = cleanSkills($skillsInput);
        saveStudent($name, $email, $skillsArray);

        $success = "Student saved successfully";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<h2>Add Student</h2>

<?php
if ($error) echo "<p style='color:red;'>$error</p>";
if ($success) echo "<p style='color:green;'>$success</p>";
?>

<form method="post">
    <input type="text" name="name" placeholder="Name"><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="text" name="skills" placeholder="Comma separated skills"><br><br>
    <button type="submit">Add Student</button>
</form>

<?php include 'footer.php'; ?>
