<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        return $this->userService->getUserAll($request->all());
    }

    public function show($id)
    {
        return $this->userService->getUserId($id);
    }

    public function store(UserRequest $request)
    {
        return $this->userService->postUser($request->all());
    }

    public function update(UserRequest $request, $id)
    {
        return $this->userService->putUser($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->userService->deleteUser($id);
    }
}
