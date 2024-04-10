<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserRepository implements UserRepositoryInterface
{
    public function getUsersFiltered(string $name = null, string $last_name = null, string $mobile = null, bool $status = null)
    {
        $cacheKey = 'users_filtered_' . md5(json_encode([$name, $last_name, $mobile, $status]));
        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($name, $last_name, $mobile, $status) {
            $query = User::query();

            if (!is_null($name)) {
                $query->where('name', 'like', '%' . $name . '%');
            }
            if (!is_null($last_name)) {
                $query->where('last_name', 'like', '%' . $last_name . '%');
            }
            if (!is_null($mobile)) {
                $query->where('mobile', 'like', '%' . $mobile . '%');
            }
            if (!is_null($status)) {
                $query->where('status', $status);
            }

            return $query->get();
        });
    }

    public function getUserById(int $userId): ?User
    {
        return User::find($userId);
    }

    public function create(array $data): User
    {
        $user = new User();
        if (isset($data['email'])) {
            $user->email = $data['email'];
        } elseif (isset($data['mobile'])) {
            $user->mobile = $data['mobile'];
        } elseif (isset($data['telegram_id'])) {
            $user->telegram_id = $data['telegram_id'];
        }
        $user->save();
        return $user;
    }

    public function findByIdentity(string $identity): ?User
    {
        return User::where('email', $identity)
            ->orWhere('mobile', $identity)
            ->orWhere('telegram', $identity)
            ->first();
    }

    public function saveProfile($user, $profileData)
    {
        $user->profile()->updateOrCreate([], $profileData);
    }

    public function findUserById($id)
    {
        return Profile::with('user')->findOrFail($id);

    }

    public function findProfileById($profileId): ?Profile
    {
        return Profile::findOrFail($profileId);
    }

        public function updateProfile($profileId, array $newDetails)
    {
        return Profile::whereId($profileId)->update($newDetails);
    }

    public function updateUser($userId, array $data)
    {
        $user = $this->getUserById($userId);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

}
