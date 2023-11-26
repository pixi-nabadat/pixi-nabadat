<?php

namespace App\Console\Commands;

use App\Enum\UserPackageStatusEnum;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireUserPackageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-package:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove the expired user packages for users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::now()->setTimezone('Africa/Cairo')->format('Y-m-d');
        $userPackages = UserPackage::query()->whereDate('expire_date', $currentDate)->get();
        foreach($userPackages as $package)
        {
           UserPackage::getNextReadyPackageForExpirePackage(user: $package->user, userPackage: $package);
        }
        return Command::SUCCESS;
    }
}
