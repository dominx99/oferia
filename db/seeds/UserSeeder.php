<?php

use App\Database\Seeder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factory;

class UserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->boot();

        for ($i = 1; $i <= 30; $i++) {
            $this->factory->create(User::class);
        }
    }
}
