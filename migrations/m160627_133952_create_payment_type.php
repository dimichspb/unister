<?php

use yii\db\Migration;

/**
 * Handles the creation for table `payment_type`.
 */
class m160627_133952_create_payment_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%payment_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%payment_type}}');
    }
}
