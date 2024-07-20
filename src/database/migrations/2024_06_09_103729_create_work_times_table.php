<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // 外部のユーザーID
            $table->datetime('start_work')->nullable(); // 勤務開始時間
            $table->datetime('end_work')->nullable(); // 勤務終了時間
            $table->datetime('start_break')->nullable(); // 休憩開始時間
            $table->time('break_duration')->nullable(); // 休憩時間
            $table->time('work_duration')->nullable(); // 勤務時間
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_times', function (Blueprint $table) {
            $table->dropColumn('start_break');
        });
    }
}
