<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = 1; // Example user ID
        $users = User::nestedWhere('id', $id)->get();

//        $user = Cache::asyncRemember('user_'.$id, 600, function () use ($id) {
//            return User::find($id);
//        });
        Log::info('Test command executed');
        dd('Test command executed');
    }
}
