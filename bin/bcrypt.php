<?php

var_dump($argc);
var_dump($argv);

echo json_encode(['ROLE_ADMIN','ROLE_USER']);
exit();

if ($argc > 1) {
    $toto = password_hash($argv[1], PASSWORD_BCRYPT);
}
var_dump($toto);
var_dump(password_verify('621960',$toto));
$hash = "$2y$10$4ous2lIu5K54pNVXkPPxnuLi2Ram2kefj2PTjTWr2si9jnOZamUVO";
var_dump(password_verify('621960',$hash));
exit;

$mysqli = new mysqli('localhost', 'root', '', 'sf4');

$res = $mysqli->query("select * from adherent");

while($data = $res->fetch_assoc()) {
	$code_secret = $data['code_secret'];
	$encrypted = password_hash($code_secret,PASSWORD_BCRYPT);
	echo $data['id'] . " : " . "$code_secret => $encrypted\n";
	//var_dump($mysqli->query("update adherent set password = '$encrypted' where id = ".$data['id']));
}