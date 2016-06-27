<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aircraft`.
 */
class m160627_093300_create_aircraft extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%aircraft}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'icao' => $this->string(4)->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%aircraft}}');
    }
}
