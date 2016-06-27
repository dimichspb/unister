<?php

use yii\db\Migration;

/**
 * Handles the creation for table `airline`.
 */
class m160627_081329_create_airline extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%airline}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'iata' => $this->string(2)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%airline}}');
    }
}
