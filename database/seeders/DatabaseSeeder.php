<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 取消外键约束（后面章节将介绍外键约束）
        Schema::disableForeignKeyConstraints();
        Animal::truncate();
        User::truncate();
        Type::truncate();

        // 先产生 Type 资料
        Type::factory(5)->create();
        
        // 建立5笔会员测试资料
        User::factory(5)->create();

        // 建立一万笔动物测试资料
        Animal::factory(10000)->create();

        // 开启外键约束
        Schema::enableForeignKeyConstraints();

    }
}
