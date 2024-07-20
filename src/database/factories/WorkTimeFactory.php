<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\WorkTime;
use Illuminate\Support\Carbon;

class WorkTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = WorkTime::class;

    public function definition()
    {
        $start_work = $this->faker->dateTimeBetween('-1 month', 'now');
        $end_work = (clone $start_work)->modify('+' . rand(4, 8) . ' hours');
        $break_duration = $this->faker->numberBetween(0, 60); // 0分から60分の間の休憩時間

        // 勤務時間は勤務終了時間 - 勤務開始時間 - 休憩時間
        $work_duration = Carbon::createFromTimestamp($end_work->getTimestamp())
            ->diffInMinutes(Carbon::createFromTimestamp($start_work->getTimestamp())) - $break_duration;

        return [
            'user_id' => User::factory(), // ユーザーのファクトリを使って関連付ける
            'start_work' => $start_work,
            'end_work' => $end_work,
            'break_duration' => gmdate('H:i:s', $break_duration * 60), // 分を時間に変換
            'work_duration' => gmdate('H:i:s', $work_duration * 60), // 分を時間に変換
        ];
    }
}
