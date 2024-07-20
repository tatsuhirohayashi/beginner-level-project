<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkTime;
use App\Models\User;
use Carbon\Carbon;

class WorkTimeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 初めてログインした場合、work_statusをnot_workingに設定
        if (is_null($user->work_status)) {
            $user->work_status = 'not_working';
            $user->save();
        }

        return view('index');
    }

    public function startWork()
    {
        $user = Auth::user();

        $existingWorkTime = WorkTime::where('user_id', $user->id)
            ->whereNotNull('start_work')
            ->whereNull('end_work')
            ->orderBy('start_work', 'desc')
            ->first();

        if ($existingWorkTime) {
            // 日付変更チェック
            $this->checkForDateChange($existingWorkTime, $user);

            return redirect('/');
        }

        $workTime = new WorkTime();
        $workTime->user_id = $user->id;
        $workTime->start_work = now();
        $workTime->save();

        // ユーザーの勤務状態を更新
        $user->work_status = 'working';
        $user->save();

        return redirect('/');
    }

    public function endWork()
    {
        $user = Auth::user();

        $workTime = WorkTime::where('user_id', $user->id)
            ->whereNotNull('start_work')
            ->whereNull('end_work')
            ->orderBy('start_work', 'desc')
            ->first();

        if ($workTime) {
            // 日付変更チェック
            $newWorkTime = $this->checkForDateChange($workTime, $user);

            if ($newWorkTime) {
                $workTime = $newWorkTime;
            }

            $workTime->end_work = now();
            $start_work = Carbon::parse($workTime->start_work);
            $end_work = Carbon::parse($workTime->end_work);

            $work_duration = $end_work->diffInSeconds($start_work);

            if ($workTime->break_duration) {
                $break_duration = Carbon::parse($workTime->break_duration)->diffInSeconds(Carbon::today());
                $work_duration -= $break_duration;
            } else {
                $workTime->break_duration = '00:00:00';
            }

            $hours = floor($work_duration / 3600);
            $minutes = floor(($work_duration % 3600) / 60);
            $seconds = $work_duration % 60;

            $workTime->work_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            $workTime->save();

            $user->work_status = 'not_working';
            $user->save();

            return redirect('/');
        }

        return redirect('/');
    }

    public function startBreak()
    {
        $user = Auth::user();

        $workTime = WorkTime::where('user_id', $user->id)
            ->whereNull('end_work')
            ->orderBy('start_work', 'desc')
            ->first();

        if ($workTime) {
            // 日付変更チェック
            $newWorkTime = $this->checkForDateChange($workTime, $user);

            if ($newWorkTime) {
                $workTime = $newWorkTime;
            }

            $workTime->start_break = now();
            $workTime->save();

            $user->work_status = 'on_break';
            $user->save();

            return redirect('/');
        }

        return redirect('/');
    }

    public function endBreak()
    {
        $user = Auth::user();

        // 現在の勤務記録を取得（最も新しいレコード）
        $workTime = WorkTime::where('user_id', $user->id)
            ->whereNotNull('start_work')
            ->whereNull('end_work')
            ->orderBy('start_work', 'desc')
            ->first();

        if ($workTime) {
            // 日付変更チェック
            $newWorkTime = $this->checkForDateChange($workTime, $user);

            if ($newWorkTime) {
                $workTime = $newWorkTime;
            }

            $end_break = now();
            $start_break = Carbon::parse($workTime->start_break);
            $break_duration = $end_break->diffInSeconds($start_break);

            // 既存の休憩時間がある場合、累積する
            if ($workTime->break_duration) {
                $existing_break_duration = Carbon::parse($workTime->break_duration)->secondsSinceMidnight();
                $total_break_duration = $existing_break_duration + $break_duration;
            } else {
                $total_break_duration = $break_duration;
            }

            // 合計休憩時間をフォーマットして保存
            $hours = floor($total_break_duration / 3600);
            $minutes = floor(($total_break_duration % 3600) / 60);
            $seconds = $total_break_duration % 60;

            $workTime->break_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            $workTime->start_break = null; // 休憩開始時刻をリセット
            $workTime->save();

            // ユーザーの勤務状態を更新
            $user->work_status = 'working';
            $user->save();

            return redirect('/');
        }

        return redirect('/');
    }

    public function attendance(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $worktimes = Worktime::with('user')
            ->whereDate('start_work', $date)
            ->paginate(5);
        $users = User::all();

        return view('attendance', compact('worktimes', 'users', 'date'));
    }

    public function allUsers(Request $request)
    {
        $users = User::Paginate(5);

        return view('users', compact('users'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        $worktimes = WorkTime::where('user_id', $id)->paginate(5);

        return view('user', compact('user', 'worktimes'));
    }

    public function checkForDateChange($workTime, $user)
    {
        $currentDate = Carbon::now()->toDateString();
        $workStartDate = Carbon::parse($workTime->start_work)->toDateString();

        if ($currentDate !== $workStartDate) {
            $endOfDay = Carbon::parse($workStartDate . ' 23:59:59');

            // 勤務終了処理
            $workTime->end_work = $endOfDay;

            // 勤務時間を計算
            $start_work = Carbon::parse($workTime->start_work);
            $end_work = Carbon::parse($workTime->end_work);
            $work_duration = $end_work->diffInSeconds($start_work);

            if ($workTime->break_duration) {
                $break_duration = Carbon::parse($workTime->break_duration)->diffInSeconds(Carbon::today());
                $work_duration -= $break_duration;
            } else {
                $workTime->break_duration = '00:00:00';
            }

            if ($user->work_status === 'on_break') {
                // 休憩終了処理
                $end_break = $endOfDay;
                $start_break = Carbon::parse($workTime->start_break);
                $break_duration = $end_break->diffInSeconds($start_break);

                if ($workTime->break_duration) {
                    $existing_break_duration = Carbon::parse($workTime->break_duration)->secondsSinceMidnight();
                    $total_break_duration = $existing_break_duration + $break_duration;
                } else {
                    $total_break_duration = $break_duration;
                }

                $hours = floor($total_break_duration / 3600);
                $minutes = floor(($total_break_duration % 3600) / 60);
                $seconds = $total_break_duration % 60;
                $workTime->break_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

                // 勤務時間から休憩時間を引く
                $work_duration -= $break_duration;
            }

            // 修正後の勤務時間を再計算して保存
            $hours = floor($work_duration / 3600);
            $minutes = floor(($work_duration % 3600) / 60);
            $seconds = $work_duration % 60;
            $workTime->work_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

            $workTime->save();

            // 新しい日の勤務記録を開始
            $newWorkTime = new WorkTime();
            $newWorkTime->user_id = $user->id;
            $newWorkTime->start_work = Carbon::parse($currentDate . ' 00:00:00');

            if ($user->work_status === 'on_break') {
                $newWorkTime->start_break = Carbon::parse($currentDate . ' 00:00:00');
            }

            $newWorkTime->save();

            // ユーザーの勤務状態を更新
            $user->work_status = $user->work_status === 'on_break' ? 'on_break' : 'working';
            $user->save();

            return $newWorkTime;
        }

        return null;
    }
}
