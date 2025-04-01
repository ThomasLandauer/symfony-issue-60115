<?php declare(strict_types = 1);
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?string $email = null;

    #[ORM\Column]
    /** @var array<int,string> $roles */
    private array $roles = [];

    /** @var ?string The *hashed* password */
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    private ?string $plainPassword = null;

    /**
     * A visual identifier that represents this user.
     * @see UserInterface::getUserIdentifier()
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface::getRoles()
     * @return array<int, string>
     */
    public function getRoles(): array
    {
        // return $this->roles;
        return ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
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
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(?string $password): static
    {
        $this->password = $password;
        return $this;
    }
    /** @psalm-mutation-free */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }
    /**
     * @see UserInterface::eraseCredentials()
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->setPlainPassword(null);
    }
}
