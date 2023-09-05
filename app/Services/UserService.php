<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserAll($request)
    {
        return Cache::remember('user', env('TIME_CACHE', 60), function () use ($request) {
            $user = Utils::search($this->user, $request);
            return  UserResource::collection(Utils::pagination($user, $request));
        });
    }

    public function getUserId($id)
    {
        return $this->user->findOrFail($id);
    }

    public function postUser($request)
    {
        Cache::forget('user');
        $user = new User;
        $request['password'] = Hash::make($request['password']);
        $user = $user->create($request);
        return $this->user::find($user->id);
    }

    public function putUser($request, $id)
    {
        Cache::forget('user');
        $user = $this->user->findOrFail($id);
        if (array_key_exists('password', $request)) {
            $request['password'] = Hash::make($request['password']);
        }
        $user->fill($request)->save();
        return $this->user->find($id);
    }

    public function deleteUser($id)
    {
        Cache::forget('user');
        $this->user->findOrFail($id)->delete();
        return true;
    }
}
