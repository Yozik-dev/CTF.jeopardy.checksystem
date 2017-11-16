<?php

use yii\db\Migration;

class m161013_061130_guest_team extends Migration
{
    public function up()
    {
        $this->addColumn('users', 'is_guest', 'TINYINT UNSIGNED NOT NULL DEFAULT 0 AFTER vk_id');
    }

    public function down()
    {
        $this->dropColumn('users', 'is_guest');
    }

}
