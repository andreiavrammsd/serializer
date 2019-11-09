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

$string = '[
    {
        "age": 32,
        "amount": 40,
        "created_at": "2016-01-02 23:12:00",
        "first_name": "John",
        "friends": null,
        "is_admin": true,
        "size": "9A",
        "tags": null
    },
    {
        "age": 45,
        "amount": 0,
        "created_at": null,
        "first_name": "anna",
        "friends": null,
        "is_admin": false,
        "related": {
            "age": 32,
            "amount": 40,
            "created_at": "2016-01-02 23:12:00",
            "first_name": "John",
            "friends": null,
            "is_admin": true,
            "size": "9A",
            "tags": null
        },
        "size": "9.4",
        "tags": [
            1,
            2,
            3
        ]
    },
    {
        "age": 28,
        "amount": 0,
        "created_at": "1994-05-05 00:00:37",
        "first_name": "DON",
        "friends": [
            {
                "age": 32,
                "amount": 40,
                "created_at": "2016-01-02 23:12:00",
                "first_name": "John",
                "friends": null,
                "is_admin": true,
                "size": "9A",
                "tags": null
            },
            {
                "age": 45,
                "amount": 0,
                "created_at": null,
                "first_name": "anna",
                "friends": null,
                "is_admin": false,
                "related": {
                    "age": 32,
                    "amount": 40,
                    "created_at": "2016-01-02 23:12:00",
                    "first_name": "John",
                    "friends": null,
                    "is_admin": true,
                    "size": "9A",
                    "tags": null
                },
                "size": "9.4",
                "tags": [
                    1,
                    2,
                    3
                ]
            }
        ],
        "is_admin": false,
        "related": {
            "age": 32,
            "amount": 40,
            "created_at": "2016-01-02 23:12:00",
            "first_name": "John",
            "friends": null,
            "is_admin": true,
            "size": "9A",
            "tags": null
        },
        "size": "A",
        "tags": [
        ],
        "team": [
            {
                "age": 32,
                "amount": 40,
                "created_at": "2016-01-02 23:12:00",
                "first_name": "John",
                "friends": null,
                "is_admin": true,
                "size": "9A",
                "tags": null
            },
            {
                "age": 45,
                "amount": 0,
                "created_at": null,
                "first_name": "anna",
                "friends": null,
                "is_admin": false,
                "related": {
                    "age": 32,
                    "amount": 40,
                    "created_at": "2016-01-02 23:12:00",
                    "first_name": "John",
                    "friends": null,
                    "is_admin": true,
                    "size": "9A",
                    "tags": null
                },
                "size": "9.4",
                "tags": [
                    1,
                    2,
                    3
                ]
            }
        ]
    }
]';

try {
    $users = $serializer->unserialize($string, Users::class);
} catch (SerializerException $e) {
    die($e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}

/** @var User $user */
foreach ($users as $user) {
    displayUser($user);
    echo str_repeat('=', 30);
    echo "\n";
}

function displayUser(User $user)
{
    echo "First name:\t" . $user->getFirstName() . "\n";
    echo "Age:\t\t" . $user->getAge() . "\n";
    echo "Amount:\t\t" . $user->getAmount() . "\n";
    echo "Is admin:\t" . ($user->isAdmin() ? 'yes' : 'no') . "\n";
    echo "Created:\t" . ($user->getCreatedAt() ? $user->getCreatedAt()->format("d/m/Y @ H:i:s") : '') . "\n";

    if ($user->getRelated()) {
        echo "\nRelated:\n";
        displayUser($user->getRelated());
    }

    if ($user->getFriends()) {
        echo "\nFriends:\n";
        foreach ($user->getFriends() as $friend) {
            displayUser($friend);
            echo "\n";
        }
        echo "\n";
    }

    if ($user->getTeam()) {
        echo "\nTeam:\n";
        foreach ($user->getTeam() as $member) {
            displayUser($member);
            echo "\n";
        }
        echo "\n";
    }

    echo "Tags:\t" . ($user->getTags() ? implode(',', $user->getTags()) : '') . "\n";
}
