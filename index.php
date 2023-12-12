<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bazaxd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $voivodeship = mysqli_real_escape_string($conn, $_POST['voivodeship']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, dob, email, phone, voivodeship, gender, newsletter)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $firstName, $lastName, $dob, $email, $phone, $voivodeship, $gender, $newsletter);

    if ($stmt->execute()) {
        echo "Rejestracja zakończona pomyślnie.";
    } else {
        echo "Błąd: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formularz Rejestracyjny</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
    body {
      background-color: #f0f0f0;
    }
    .container {
      margin-top: 50px;
    }
  </style>
</head>
<body>

<div class="container">
  <form id="registrationForm" method="post" action="index.php">
    <div class="form-group">
      <label for="firstName">Imię:</label>
      <input type="text" class="form-control" id="firstName" name="firstName" required>
    </div>
    <div class="form-group">
      <label for="lastName">Nazwisko:</label>
      <input type="text" class="form-control" id="lastName" name="lastName" required>
    </div>
    <div class="form-group">
      <label for="dob">Data urodzenia:</label>
      <input type="date" class="form-control" id="dob" name="dob" required>
    </div>
    <div class="form-group">
      <label for="email">Adres email:</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="phone">Telefon:</label>
      <input type="tel" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="form-group">
      <label for="voivodeship">Województwo:</label>
      <select class="form-control" id="voivodeship" name="voivodeship" required>
        <option value="1">Mazowieckie</option>
        <option value="2">Małopolskie</option>
        <option value="3">Śląskie</option>
        <option value="4">Inne</option>
      </select>
    </div>
    <div class="form-group">
      <label>Płeć:</label>
      <div class="form-check">
        <input type="radio" class="form-check-input" id="male" name="gender" value="male" required>
        <label class="form-check-label" for="male">Mężczyzna</label>
      </div>
      <div class="form-check">
        <input type="radio" class="form-check-input" id="female" name="gender" value="female" required>
        <label class="form-check-label" for="female">Kobieta</label>
      </div>
    </div>
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" id="newsletter" name="newsletter">
      <label class="form-check-label" for="newsletter">Zgoda na newsletter</label>
    </div>
    <button type="submit" class="btn btn-primary">Zarejestruj</button>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
  $(document).ready(function () {
    $('#registrationForm').validate();
  });
</script>

</body>
</html>
