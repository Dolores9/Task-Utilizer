<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateUsersAdminField extends Migration
{
    public function up()
    {
        DB::table('users')->where('email', 'dolores.admin@mail.com')->update(['admin' => 1]); // Update specific user
    }

    public function down()
    {
        // Optional: Define how to revert the changes if needed
    }
}
