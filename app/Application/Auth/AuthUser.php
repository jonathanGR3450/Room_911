<?php

declare(strict_types=1);

namespace App\Application\Auth;

use App\Application\Auth\Contracts\AuthUserInterface;
use App\Application\User\CreateUserUseCase;
use App\Domain\User\Aggregate\User;
use App\Domain\User\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

final class AuthUser implements AuthUserInterface
{
    private UserRepositoryInterface $userRepositoryInterface;
    private CreateUserUseCase $createUserUseCase;

    public function __construct(UserRepositoryInterface $userRepositoryInterface, CreateUserUseCase $createUserUseCase) {
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->createUserUseCase = $createUserUseCase;
    }
    
    public function loginCredentials(string $email, string $password): string
    {
        $credentials = compact('email', 'password');
        try {
            if (! $token = Auth::attempt($credentials)) {
                throw new UnauthorizedException('invalid_credentials');
            }
        } catch (Exception $e) {
            throw new UnauthorizedException('could_not_create_token');
        }
        return '';
    }

    public function loginUserModel(User $user): string
    {
        $user = $this->userRepositoryInterface->findByIdGetModel($user->id());
        return '';
    }

    public function getAuthUser(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }

    public function createUser(string $name, string $email, string $password): User
    {
        $user = $this->createUserUseCase->__invoke($name, $email, $password);
        return $user;
    }

    public function logout(): void
    {
        
    }

    public function refresh(): string
    {
        return '';
    }

    public function getAuthenticatedUser(): \Illuminate\Contracts\Auth\Authenticatable
    {
        $user = Auth::user();
        return $user;
    }
}
