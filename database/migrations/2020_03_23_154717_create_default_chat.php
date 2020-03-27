<?php

use App\Models\Chat;
use Illuminate\Database\Migrations\Migration;

/**
 * Добавление стандартного чата в таблицу `chats`
 *
 * Class CreateDefaultChat
 */
class CreateDefaultChat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Chat::create([
            'index' => Chat::DEFAULT_CHAT_INDEX,
            'name' => 'Просто чат',
            'is_dialog' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Chat::where('index', Chat::DEFAULT_CHAT_INDEX)->delete();
    }
}
