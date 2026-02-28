<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class BossUser extends Model
{
    protected ?string $table = 'boss_user';

    public bool $timestamps = true;

    protected array $fillable = [
        'id',
        'username',
        'password_hash',
        'status',
        'last_login_at',
    ];

    protected array $hidden = [
        'password_hash',
    ];

    protected array $casts = [
        'id' => 'integer',
        'status' => 'integer',
    ];
}
