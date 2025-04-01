<?php declare(strict_types = 1);
namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LogintokenRepository;

#[ORM\Entity(repositoryClass: LogintokenRepository::class)]
#[ORM\Table()]
#[ORM\UniqueConstraint(name: 'logintoken_user_id', columns: ['user_id'])]
#[ORM\UniqueConstraint(name: 'logintoken_token', fields: ['token'])]
class Logintoken
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user;

    #[ORM\Column]
    private string $token;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }
    public function getToken(): string
    {
        return $this->token;
    }
}
