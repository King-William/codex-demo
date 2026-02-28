<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\FoodService;
use Hyperf\HttpServer\Contract\RequestInterface;

class FoodController
{
    public function __construct(private readonly FoodService $foodService)
    {
    }

    public function index(RequestInterface $request): array
    {
        $query = $request->all();
        $page = max(1, (int) ($query['page'] ?? 1));
        $pageSize = min(100, max(1, (int) ($query['page_size'] ?? 20)));

        return $this->foodService->paginate($query, $page, $pageSize);
    }

    public function show(int $id): array
    {
        return $this->foodService->detail($id);
    }

    public function store(RequestInterface $request): array
    {
        $food = $this->foodService->create($request->all());

        return ['id' => $food->id];
    }

    public function update(int $id, RequestInterface $request): array
    {
        $food = $this->foodService->update($id, $request->all());

        return ['id' => $food->id];
    }

    public function destroy(int $id): array
    {
        $this->foodService->delete($id);

        return ['id' => $id];
    }
}
