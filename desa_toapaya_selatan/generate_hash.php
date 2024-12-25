<?php
// Daftar password yang ingin di-hash
$passwords = [
    'admin20',
    'user20',
    'Rave123'
];

// Loop untuk menghasilkan hash untuk setiap password
foreach ($passwords as $password) {
    // Generate password hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menampilkan hasil hash
    echo "Password: $password<br>";
    echo "Hashed: $hashed_password<br><br>";
}
?>
