<?php

use yii\db\Migration;

/**
 * Handles the creation for table `booking`.
 */
class m160627_133952_create_booking extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%booking}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'flight_id' => $this->integer()->notNull(),
            'adults' => $this->integer()->notNull()->defaultValue(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%booking}}');
    }
}
