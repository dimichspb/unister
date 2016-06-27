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
            'origin_id' => $this->integer()->notNull(),
            'destination_id' => $this->integer()->notNull(),
            'departure' => $this->dateTime()->notNull(),
            'arrival' => $this->dateTime()->notNull(),
            'airline_id' => $this->integer()->notNull(),
            'aircraft_id' => $this->integer()->notNull(),
            'number' => $this->string(4)->notNull(),
            'seats' => $this->integer(3)->notNull(),
            'price' => $this->float(2)->notNull(),
        ]);

        $this->createIndex('idx_unique', '{{%flight}}', ['origin_id', 'destination_id', 'departure', 'arrival', 'airline_id', 'number'], true);

        $this->addForeignKey('fk_flight_origin_city', '{{%flight}}', 'origin_id', '{{%city}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_flight_destination_city', '{{%flight}}', 'destination_id', '{{%city}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_flight_airline', '{{%flight}}', 'airline_id', '{{%airline}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_flight_aircraft', '{{%flight}}', 'aircraft_id', '{{%aircraft}}', 'id', 'RESTRICT', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%flight}}');
    }
}
