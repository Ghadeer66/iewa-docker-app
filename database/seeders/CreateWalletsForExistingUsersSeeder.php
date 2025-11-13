<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateWalletsForExistingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $users = User::doesntHave('wallet')->get();

            foreach ($users as $user) {
                Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0, // start with zero balance
                ]);
            }

            $this->command->info('✅ Wallets created for ' . $users->count() . ' users.');
        });
    }
}
