<?php

// create_user.php <name>

use App\Entity\TodoList;
use App\Entity\User;

require_once "bootstrap.php";

$username = $argv[1];
$password = $argv[2];
$role = $argv[3];

$user = new User($username, $password, $role);

$entityManager->persist($user);
$entityManager->flush();

echo "Created Usere with ID " . $user->getId() . "\n";
