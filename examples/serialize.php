<?php declare(strict_types=1);

use Serializer\Factory;
use Serializer\SerializerException;

require dirname(__DIR__) . '/vendor/autoload.php';
require __DIR__ . '/data.php';

try {
    $serializer = Factory::create();
} catch (SerializerException $e) {
    die($e->getMessage());
}

$john = new User();
$john->setFirstName("John");
$john->setAge(32);
$john->setAmount(40);
$john->setSize("9A");
$john->setIsAdmin(true);
$john->setCreatedAt(new DateTime("2016-01-02 23:12:00"));

$anna = new User();
$anna->setFirstName("anna");
$anna->setAge(45);
$anna->setAmount(0);
$anna->setSize("9.4");
$anna->setIsAdmin(false);
$anna->setRelated($john);
$anna->setTags([1, 2, 3]);

$don = new User();
$don->setFirstName("DON");
$don->setAge(28);
$don->setAmount(0);
$don->setSize("A");
$don->setCreatedAt(new DateTime("1994-05-05 00:00:37"));
$don->setRelated($john);
$don->setFriends(new Friends([$john, $anna]));
$don->setTeam([$john, $anna]);
$don->setTags([]);

$users = new Users([$john, $anna, $don]);

try {
    $string = $serializer->serialize($users);
} catch (SerializerException $e) {
    die($e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}

echo $string;
