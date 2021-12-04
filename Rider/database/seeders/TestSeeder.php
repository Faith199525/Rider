<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rider;
use App\Models\Driver;
use App\Models\Bus;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Emma',
            'email' => 'emma@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'name' => 'Ezinne',
            'email' => 'Ezinne@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $rider = new Rider;
        $rider->user_id = $user1->id;
        $rider->save();

        $driver = new Driver;
        $driver->user_id = $user1->id;
        $driver->save();

        $bus = Bus::create([
            'serial_no' => '909',
            'seats' => 5,
            'plate_no' => '908667AFHU',
            'driver_id' => $driver->id
        ]);
    }
}
