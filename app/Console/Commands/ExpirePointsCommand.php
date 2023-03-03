<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpirePointsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove the expired points for users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::today());
        $users = User::where('points_expire_date','<=',$currentDate)->get();
        foreach($users as $user)
        {
            $user->update([
                'points'=> 0,
                'points_expire_date'=> null,
            ]);
        }
        return Command::SUCCESS;
    }
}
