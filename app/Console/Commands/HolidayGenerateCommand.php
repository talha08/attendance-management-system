<?php

namespace App\Console\Commands;

use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;
class HolidayGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holiday:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yearly Holiday Generate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Start of Holiday Genearte');
        $now = new DateTime( 'now', new DateTimeZone( 'America/New_York' ) );
        //Create a DateTime representation of the first day of the current month based off of "now"
        $start = new DateTime( $now->format('01/t/Y'), new DateTimeZone( 'America/New_York' ) );
        //Create a DateTime representation of the last day of the current month based off of "now"
        $end = new DateTime( $now->format('m/t/Y'), new DateTimeZone( 'America/New_York' ) );
        //Define our interval (1 Day)
        $interval = new DateInterval('P1D');
        //Setup a DatePeriod instance to iterate between the start and end date by the interval
        $period = new DatePeriod( $start, $interval, $end );
        //Iterate over the DatePeriod instance
        foreach( $period as $date ){
            //Make sure the day displayed is ONLY sunday.
            if( $date->format('w') == 0 || $date->format('w') == 6 ){
                $holiday = \App\Models\WorkHolidays::where('occasion','Office Holiday')
                    ->where('date',$date->format('Y-m-d' ))
                    ->first();
                if(!$holiday){
                    $holiday = new \App\Models\WorkHolidays();
                    $holiday->date =  $date->format('Y-m-d' );
                    $holiday->occasion = 'Office Holiday';
                    $holiday->save();
                }
            }
        }
        $this->line('End of Holiday Genearte');
    }

}
