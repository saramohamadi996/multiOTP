<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;

    public function findByIdentity(string $identity): ?User;

    public function findProfileById($profileId): ?Profile;

    public function updateProfile($profileId, array $newDetails);
}
