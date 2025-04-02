<?php
$password = "123456789halohalo1";
$password_hashed = password_hash($password, PASSWORD_BCRYPT);
echo $password_hashed;

$passwordreceive = $password;
if (!empty($password_hashed)) {
	$isPasswordCorrect = password_verify($passwordreceive, $password_hashed);
	echo $isPasswordCorrect ? 'Password is correct' : 'Password is incorrect';
} else {
	echo 'Error: Hashed password does not exist.';
}
?>