<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'mysql';
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
            $table->date('pub_date');
            $table->string('link');
            $table->string('img');
            $table->string('title');
            $table->text('excerpt');
            $table->string('author');
            $table->string('tags');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
        });

        DB::table('tags')->insert
        (
                [
                    [
                        'tag' => 'News',
                    ],
                    [
                        'tag' => 'Sponsor',
                    ],
                    [
                        'tag' => 'Packages',
                    ],
                    [
                        'tag' => 'Developer Tools',
                    ],
                    [
                        'tag' => 'Laravel Applications',
                    ]
                ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
