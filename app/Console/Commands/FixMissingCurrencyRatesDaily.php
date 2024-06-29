<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Log;
use DatePeriod;
use DateTime;
use Illuminate\Console\Command;
use App\Models\Accounts\Currency;
use App\Models\Accounts\CurrencyRate;
use Illuminate\Database\QueryException;
use App\Services\Admin\iUserService;

class FixMissingCurrencyRatesDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FixMissingCurrencyRatesDaily:Process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param iUserService $userService
     * @return mixed
     */
    public function handle(iUserService $userService)
    {
        $systemUser = $userService->getSystemUser();
        $rates = CurrencyRate::with('currency');

        $rates = $rates->where('date', '>=', now()->yesterday())
            ->where('date', '<', today());

        $existingRates = $rates->get();
        $this->info($existingRates->count());

        $bar = $this->output->createProgressBar($existingRates->count());
        foreach ($existingRates as $existingRate) {
            $newRate = $existingRate->replicate();
            $newRate->date = now()->format('Y-m-d');
            try
            {
                $newRate->created_by = $systemUser->id;
                $newRate->created_at = Carbon::now();
                $newRate->save();
            }
            catch (QueryException $ex)
            {
                $this->info($ex->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();

        $this->info("\nProcessing done.");
    }
}
