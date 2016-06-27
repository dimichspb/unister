<?php

use yii\db\Migration;

/**
 * Handles the creation for table `booking`.
 */
class m160627_134834_create_booking extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%booking}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'flight_id' => $this->integer()->notNull(),
            'adults' => $this->integer()->notNull()->defaultValue(1),
            'payment_type_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_booking_user_id', '{{%booking}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_booking_flight_id', '{{%booking}}', 'flight_id', '{{%flight}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_booking_payment_type_id', '{{%booking}}', 'payment_type_id', '{{%payment_type}}', '{{%id}}', 'RESTRICT', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%booking}}');
    }
}
