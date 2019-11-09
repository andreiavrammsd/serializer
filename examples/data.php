<?php declare(strict_types=1);

use Serializer\Collection;

class User
{
    /**
     * @Serializer\Property("first_name")
     * @Serializer\Callback("ucfirst")
     */
    private $firstName;

    /**
     * @Serializer\Property("age")
     * @Serializer\Type("int")
     */
    private $age;

    /**
     * @Serializer\Type("float")
     */
    private $amount;

    /**
     * @Serializer\Type("string")
     */
    private $size;

    /**
     * @Serializer\Property("is_admin")
     * @Serializer\Type("bool")
     */
    private $isAdmin = false;

    /**
     * @Serializer\Property("created_at")
     * @Serializer\Type("DateTime", "Y-m-d H:i:s")
     */
    private $createdAt;

    /**
     * @Serializer\Property("related")
     * @Serializer\Type("User")
     * @Serializer\IgnoreNull()
     */
    private $related;

    /**
     * @Serializer\Property("friends")
     * @Serializer\Type("collection[User]")
     */
    private $friends;

    /**
     * @Serializer\Property("team")
     * @Serializer\Type("array[User]")
     * @Serializer\IgnoreNull
     */
    private $team;

    /**
     * @Serializer\Type("array")
     */
    private $tags;

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return User|null
     */
    public function getRelated(): ?User
    {
        return $this->related;
    }

    /**
     * @param User $related
     */
    public function setRelated(User $related): void
    {
        $this->related = $related;
    }

    /**
     * @return Collection|null
     */
    public function getFriends(): ?Collection
    {
        return $this->friends;
    }

    /**
     * @param Collection $friends
     */
    public function setFriends(Collection $friends): void
    {
        $this->friends = $friends;
    }

    /**
     * @return array|null
     */
    public function getTeam(): ?array
    {
        return $this->team;
    }

    /**
     * @param array $team
     */
    public function setTeam(array $team): void
    {
        $this->team = $team;
    }

    /**
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }
}

/**
 * @Serializer\Collection("User")
 */
class Friends extends Collection
{
}

/**
 * @Serializer\Collection("User")
 */
class Users extends Collection
{
}
