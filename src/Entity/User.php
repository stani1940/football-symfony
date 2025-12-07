<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(name: 'role_id', options: ['default' => 2])]
    private ?int $roleId = 2;

    #[ORM\Column(name: 'boosts_left', options: ['default' => 0])]
    private ?int $boostsLeft = 0;

    #[ORM\Column(name: 'being_notified', options: ['default' => false])]
    private ?bool $beingNotified = false;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $active = true;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $staff = false;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $admin = false;

    #[ORM\Column(name: 'hide_email', options: ['default' => false])]
    private ?bool $hideEmail = false;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): static
    {
        $this->roleId = $roleId;
        return $this;
    }

    public function getBoostsLeft(): ?int
    {
        return $this->boostsLeft;
    }

    public function setBoostsLeft(int $boostsLeft): static
    {
        $this->boostsLeft = $boostsLeft;
        return $this;
    }

    public function isBeingNotified(): ?bool
    {
        return $this->beingNotified;
    }

    public function setBeingNotified(bool $beingNotified): static
    {
        $this->beingNotified = $beingNotified;
        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;
        return $this;
    }

    public function isStaff(): ?bool
    {
        return $this->staff;
    }

    public function setStaff(bool $staff): static
    {
        $this->staff = $staff;
        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): static
    {
        $this->admin = $admin;
        return $this;
    }

    public function isHideEmail(): ?bool
    {
        return $this->hideEmail;
    }

    public function setHideEmail(bool $hideEmail): static
    {
        $this->hideEmail = $hideEmail;
        return $this;
    }

    // UserInterface methods
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        
        if ($this->admin) {
            $roles[] = 'ROLE_ADMIN';
        }
        
        if ($this->staff) {
            $roles[] = 'ROLE_STAFF';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }
}
