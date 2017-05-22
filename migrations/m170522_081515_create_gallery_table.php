<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gallery`.
 */
class m170522_081515_create_gallery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gallery', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100),
            'image' => $this->string(100),
            'key' => $this->string(100)->notNull(),
            'object_id' => $this->integer(11)->notNull(),
            'position' => $this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('gallery');
    }
}
