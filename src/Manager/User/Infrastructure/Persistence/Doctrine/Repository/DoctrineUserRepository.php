<?php

namespace App\Manager\User\Infrastructure\Persistence\Doctrine\Repository;

use App\Manager\User\Domain\Repository\UserRepositoryInterface;
use App\Manager\User\Domain\User;
use App\Manager\User\Domain\ValueObject\VOEmail;
use App\Manager\User\Domain\ValueObject\VOUserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Exception;

readonly class DoctrineUserRepository implements UserRepositoryInterface
{
    private ObjectRepository $repository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository(User::class);
    }

    /**
     * Save user to a database.
     *
     * @param User $user
     *
     * @return void
     */
    public function save(User $user): void
    {


        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Retrieve all users from a database.
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Find a user by email.
     *
     * @param VOEmail $email
     *
     * @return User|null
     */
    public function findByEmail(VOEmail $email): ?User
    {

        return $this->repository->findOneBy(['email' => $email->getValue()]);
    }

    /**
     * Delete user from
     *
     * @param VOUserId $id
     *
     * @return void
     * @throws Exception
     */
    public function delete(VOUserId $id): void
    {
        $user = $this->findById($id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();

    }

    /**
     * Find a user by id.
     *
     * @param VOUserId $id
     *
     * @return User|null
     */
    public function findById(VOUserId $id): ?User
    {

        return $this->repository->findOneBy(['id' => $id->getValue()]);
    }

    /**
     * Generate a new identity
     *
     * @return VOUserId
     */
    public function nextIdentity(): VOUserId
    {
        return VOUserId::generateNewId();
    }
}
