<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use App\Model\Food;
use App\Model\FoodSale;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;

class FoodService
{
    /**
     * @param array<string, mixed> $filters
     * @return array{list: array<int, array<string, mixed>>, total: int}
     */
    public function paginate(array $filters, int $page = 1, int $pageSize = 20): array
    {
        /** @var Builder $query */
        $query = Food::query()->where('is_deleted', 0);

        if (isset($filters['keyword']) && $filters['keyword'] !== '') {
            $keyword = (string) $filters['keyword'];
            $query->where(function (Builder $builder) use ($keyword): void {
                $builder->where('name', 'like', "%{$keyword}%")
                    ->orWhere('simple_desc', 'like', "%{$keyword}%");
            });
        }

        if (isset($filters['sale_status'])) {
            $query->where('sale_status', (int) $filters['sale_status']);
        }

        $paginator = $query->orderByDesc('sort')
            ->orderByDesc('id')
            ->paginate($pageSize, ['*'], 'page', $page);

        return [
            'list' => $paginator->items(),
            'total' => $paginator->total(),
        ];
    }

    /** @param array<string, mixed> $payload */
    public function create(array $payload): Food
    {
        return Db::transaction(function () use ($payload) {
            $food = new Food();
            $food->fill($payload);
            $food->save();

            if (! empty($payload['sale_date'])) {
                $this->upsertFoodSale($food->id, $payload);
            }

            return $food;
        });
    }

    /** @param array<string, mixed> $payload */
    public function update(int $id, array $payload): Food
    {
        return Db::transaction(function () use ($id, $payload) {
            $food = $this->findOrFail($id);
            $food->fill($payload);
            $food->save();

            if (! empty($payload['sale_date'])) {
                $this->upsertFoodSale($food->id, $payload);
            }

            return $food;
        });
    }

    public function delete(int $id): void
    {
        Db::transaction(function () use ($id): void {
            $food = $this->findOrFail($id);
            $food->is_deleted = 1;
            $food->save();

            FoodSale::query()->where('food_id', $id)->update(['is_deleted' => 1]);
        });
    }

    public function detail(int $id): array
    {
        $food = $this->findOrFail($id);
        $sales = FoodSale::query()
            ->where('food_id', $id)
            ->where('is_deleted', 0)
            ->orderBy('sale_date')
            ->get();

        return [
            'food' => $food,
            'sale_calendar' => $sales,
        ];
    }

    /** @param array<string, mixed> $payload */
    private function upsertFoodSale(int $foodId, array $payload): void
    {
        $sale = FoodSale::query()->firstOrNew([
            'food_id' => $foodId,
            'sale_date' => (string) $payload['sale_date'],
            'is_deleted' => 0,
        ]);

        $sale->stock = (int) ($payload['stock'] ?? 0);
        $sale->sale_count = (int) ($payload['sale_count'] ?? 0);
        $sale->reservation_count = (int) ($payload['reservation_count'] ?? 0);
        $sale->save();
    }

    private function findOrFail(int $id): Food
    {
        $food = Food::query()->where('id', $id)->where('is_deleted', 0)->first();

        if (! $food instanceof Food) {
            throw new BusinessException('餐品不存在');
        }

        return $food;
    }
}
