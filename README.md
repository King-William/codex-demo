# 餐品 CRUD + Boss 登录示例（Hyperf 3）

## 已实现能力
- Boss 后台登录：`POST /boss/login`
- 餐品列表：`GET /boss/foods`
- 餐品详情：`GET /boss/foods/{id}`
- 新增餐品：`POST /boss/foods`
- 更新餐品：`PUT /boss/foods/{id}`
- 删除餐品（软删）：`DELETE /boss/foods/{id}`

## 登录说明
1. 在容器中注册 JWT `Configuration`：
   - `BossAuthService::buildJwtConfig($secret)`
2. `boss_user.password_hash` 需使用 `password_hash()` 生成。
3. 登录成功后返回 `token` 和基础用户信息。

## 餐品字段建议
创建/更新餐品时，推荐请求体包括：
- `name`, `simple_desc`, `imgs`, `price`, `discount_price`, `newcomer_price`
- `description`, `sort`, `sale_status`
- 可选日历库存字段：`sale_date`, `stock`, `sale_count`, `reservation_count`

## 数据库
- 见 `database/schema.sql`。
