<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>proses data</title>
    <style>
      fieldset {
        background-color: rgb(182, 141, 201);
      }
    </style>
  </head>
  <body>
    <h2>Register</h2>

    <?php 
    $errors = array(); 

    // Mengecek apakah form telah disubmit (sesuai modul: isset($_POST['surname']) atau tombol submit)
    if (isset($_POST['submit']) || isset($_POST['surname'])) { 
        require 'validate.inc'; 
        
        // Validasi field Surname (Langkah 5)
        validateName($errors, $_POST, 'surname'); 

        // Validasi field-field lainnya (Langkah 9)
        validateEmail($errors, $_POST, 'email');
        validatePassword($errors, $_POST, 'passwd');
        validateAddress($errors, $_POST, 'address');
        validateState($errors, $_POST, 'state');
        validateGender($errors, $_POST, 'sex');

        if ($errors) { 
            // Tampilkan pesan error di atas form
            echo '<h1>Invalid, correct the following errors:</h1>'; 
            foreach ($errors as $field => $error) {
                echo "$field $error<br/>"; 
            }
            // Tampilkan kembali form yang mempertahankan isian sebelumnya (Sticky Form)
            include 'form.inc'; 
        } else { 
            // Jika semua isian valid tanpa error
            echo '<h3>Form submitted successfully with no errors</h3>'; 
        } 
    } else {
        // Tampilkan form kosong ketika halaman pertama kali dibuka
        include 'form.inc'; 
    }
    ?>
  </body>
</html>
