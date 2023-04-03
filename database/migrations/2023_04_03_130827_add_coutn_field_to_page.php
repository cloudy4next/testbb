<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoutnFieldToPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->integer('count')->default(0)->after('id');
        });
        Schema::table('research', function (Blueprint $table) {
            $table->integer('count')->default(0)->after('id');
        });
        Schema::table('notices', function (Blueprint $table) {
            $table->integer('count')->default(0)->after('id');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('count')->default(0)->after('id');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->integer('count')->default(0)->after('id');
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('count')->default(0)->after('id');

        });
        Schema::table('p_p_t_x_e_s', function (Blueprint $table) {
            $table->integer('count')->default(0)->after('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            //
        });
    }
}
