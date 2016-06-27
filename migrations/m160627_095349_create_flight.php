<?php

use yii\db\Migration;

/**
 * Handles the creation for table `flight`.
 */
class m160627_095349_create_flight extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%flight}}', [
            'id' => $this->primaryKey(),
            'origin' => $this->integer()->notNull(),
            'destination' => $this->integer()->notNull(),
            'departure' => $this->dateTime()->notNull(),
            'arrival' => $this->dateTime()->notNull(),
            'airline' => $this->integer()->notNull(),
            'aircraft' => $this->integer()->notNull(),
            'number' => $this->string(4)->notNull(),
            'seats' => $this->integer(3)->notNull(),
            'price' => $this->float(2)->notNull(),
        ]);

        $this->createIndex('idx_unique', '{{%flight}}', ['origin', 'destination', 'departure', 'arrival', 'airline', 'number'], true);

        $this->addForeignKey('fk_flight_origin_city', '{{%flight}}', 'origin', '{{%city}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_flight_destination_city', '{{%flight}}', 'destination', '{{%city}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_flight_airline', '{{%flight}}', 'airline', '{{%airline}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_flight_aircraft', '{{%flight}}', 'aircraft', '{{%aircraft}}', 'id', 'RESTRICT', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%flight}}');
    }
}
