<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Repositories\AttendanceRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UnfinishedAttendanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:unfinished';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unfinished Attendance Process';
    /**
     * @var AttendanceRepository
     */
    private $attendanceRepository;
    /**
     * @var Attendance
     */
    private $attendance;

    /**
     * Create a new command instance.
     *
     * @param AttendanceRepository $attendanceRepository
     * @param Attendance $attendance
     */
    public function __construct(AttendanceRepository $attendanceRepository, Attendance $attendance)
    {
        parent::__construct();
        $this->attendanceRepository = $attendanceRepository;
        $this->attendance = $attendance;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Start of Unfinished Attendance Process');
        $attendances = $this->attendanceRepository->getQuery()
            ->whereDay('work_date', Carbon::now()->day)
            ->where('status', '!=', 'finish')
            ->get();

        foreach ($attendances as $attendance){
            $this->attendanceRepository->update(
                [
                    'status' => 'finish',
                    'finish_time' => microtime(true)*1000,
                    'total_worked_time' => $this->attendance->getTotalWorkTime($attendance),
                ],
                $attendance->id);
        }
        $this->line('End of Unfinished Attendance Process');
    }
}
