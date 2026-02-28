CREATE TABLE `food` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT '主键id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '餐品名称',
  `simple_desc` varchar(50) NOT NULL DEFAULT '' COMMENT '简单描述',
  `imgs` varchar(700) NOT NULL DEFAULT '' COMMENT '餐品图片',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '餐品价格',
  `discount_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '折扣价',
  `newcomer_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '新人价',
  `description` text NOT NULL COMMENT '详情',
  `sale_count` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `sale_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在售 0否 1是',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除：0 否，1 是',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='餐品表';

CREATE TABLE `food_sale` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT '主键id',
  `food_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '餐品id',
  `stock` int(10) NOT NULL DEFAULT '0' COMMENT '库存',
  `sale_date` char(10) NOT NULL DEFAULT '' COMMENT '售卖日期  2025-09-19',
  `sale_count` int(10) NOT NULL DEFAULT '0' COMMENT '售卖数量',
  `reservation_count` int(10) NOT NULL DEFAULT '0' COMMENT '提早预约销量',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除：0 否，1 是',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fid_key` (`food_id`),
  KEY `sd_key` (`sale_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='餐品套餐关联表';

CREATE TABLE `boss_user` (
  `id` bigint(20) NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '' COMMENT '登录账号',
  `password_hash` varchar(255) NOT NULL DEFAULT '' COMMENT 'password_hash后的密码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1可用 0禁用',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='boss后台用户表';
