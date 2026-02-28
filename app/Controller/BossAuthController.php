<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\BossAuthService;
use Hyperf\HttpServer\Contract\RequestInterface;

class BossAuthController
{
    public function __construct(private readonly BossAuthService $authService)
    {
    }

    public function login(RequestInterface $request): array
    {
        $data = $request->all();

        return $this->authService->login(
            (string) ($data['username'] ?? ''),
            (string) ($data['password'] ?? '')
        );
    }
}
