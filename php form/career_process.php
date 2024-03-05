<?php
// Database connection
$servername = "localhost";
$username = "praba";
$password = "Inter@123";
$dbname = "careers";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  
  // File upload
  $resume = $_FILES['resume']['name'];
  $temp = $_FILES['resume']['tmp_name'];
  $file_ext = pathinfo($resume, PATHINFO_EXTENSION);
  $resume_newname = uniqid() . '.' . $file_ext;
  
  $upload_path = "uploads/";
  if(move_uploaded_file($temp, $upload_path . $resume_newname)) {
    // Insert data into database
    $sql = "INSERT INTO career (full_name, email, mobile, resume) VALUES ('$fullname', '$email', '$mobile', '$resume_newname')";
    if ($conn->query($sql) === TRUE) {
      echo "Career details submitted successfully.";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "Error uploading file.";
  }
}

$conn->close();
?>
