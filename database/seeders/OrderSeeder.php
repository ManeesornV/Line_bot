<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Order::factory(20)->create();

        $order = new Order();
        $order->name = 'rice';
        $order->type = 'main';
        $order->price = 10;
        $order->save();

        $order = new Order();
        $order->name = 'yum';
        $order->type = 'soup';
        $order->price = 50;
        $order->save();
    }
}
