<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {

            $table->id(); 
            $table->string('module_name',150)->comment('Name of the module created');
            $table->integer('parent_id')->default(0)->comment('Parent ID of the Root section');
            $table->string('status')->default('Y')->comment('Status of the record');
            $table->integer('created_by')->nullable()->comment('Who created the record');
            $table->integer('updated_by')->nullable()->comment('Who last updated the record');
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
        Schema::dropIfExists('modules');
    }
}
