<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_cases', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->comment('ID of the module created');
            $table->string('summary',2000)->comment('The test case summary');
            $table->string('description',2000)->nullable()->comment('Test case description');
            $table->string('file_name',100)->nullable()->comment('Filename of the uploaded file');
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
        Schema::dropIfExists('test_cases');
    }
}
