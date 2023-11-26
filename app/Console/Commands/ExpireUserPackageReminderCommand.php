<?php

namespace App\Console\Commands;

use App\Enum\FcmEventsNames;
use App\Enum\UserPackageStatusEnum;
use App\Models\ScheduleFcm;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireUserPackageReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-package:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remind the user that the package will expire';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //get all user packages that will expire after 5 days
        $expireDate = Carbon::now()->setTimezone('Africa/Cairo')->addDays(5)->format('Y-m-d');
        $users = UserPackage::query()->whereDate('expire_date',$expireDate)->pluck('user_id');
        $scheduleFcm  = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['USER_PACKAGE_EXPIRE_REMINDER'])
        ->first();

        if($scheduleFcm)
        {
            ScheduleFcm::UserReminderFcm($scheduleFcm, $users);
        }

        return Command::SUCCESS;
    }
}
