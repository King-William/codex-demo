<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use App\Model\BossUser;
use DateTimeImmutable;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class BossAuthService
{
    public function __construct(private readonly Configuration $jwt)
    {
    }

    /**
     * 推荐在依赖注入中注册：
     * Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($secret))
     */
    public static function buildJwtConfig(string $secret): Configuration
    {
        return Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($secret));
    }

    /** @return array{token: string, user: array<string, mixed>} */
    public function login(string $username, string $password): array
    {
        $user = BossUser::query()->where('username', $username)->first();

        if (! $user instanceof BossUser || ! password_verify($password, $user->password_hash)) {
            throw new BusinessException('账号或密码错误');
        }

        if ((int) $user->status !== 1) {
            throw new BusinessException('账号已禁用');
        }

        $now = new DateTimeImmutable();
        $token = $this->jwt->builder(new SystemClock(new \DateTimeZone('Asia/Shanghai')))
            ->issuedBy('boss-api')
            ->issuedAt($now)
            ->expiresAt($now->modify('+2 hour'))
            ->withClaim('uid', $user->id)
            ->withClaim('username', $user->username)
            ->getToken($this->jwt->signer(), $this->jwt->signingKey())
            ->toString();

        $user->last_login_at = $now->format('Y-m-d H:i:s');
        $user->save();

        return [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ];
    }
}
