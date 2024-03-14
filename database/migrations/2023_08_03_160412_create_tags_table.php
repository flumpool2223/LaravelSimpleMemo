<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            //符号ありだと外部キー制約が使えなくなるのでunsignedを使って符号なしにする　
            $table->unsignedBigInteger('id', true);
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            //論理削除を定義　deleted_at(削除された時間)を自動生成
            $table->softDeletes();
            //timestampで書いてしまうとレコード挿入時、更新時に値が入らないので、DB::rawで直接書いている
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            //データの整合性を取るための外部キー制約　usersテーブルにidとして存在するものでないといけない
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
