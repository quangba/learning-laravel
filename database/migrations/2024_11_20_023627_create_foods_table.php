<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Quan he 1 nhieu
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->longText('description');
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('foods')) {
            Schema::create('foods', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->integer('count');
                $table->longText('description');
                $table->timestamps();
                // forgeign keys
                $table->unsignedInteger('category_id')->nullable(); // Cho phép null nếu cần;
                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories') // bảng nào
                    // ->onDelete('cascade') // thằng 1 bị xoá thì thằng nhiều bị xoá theo
                    ->onDelete('set null'); // Khi category bị xóa, category_id được set thành null
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foods');
    }
}
