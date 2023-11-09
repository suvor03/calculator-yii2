<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prices}}`.
 */
class m231108_173348_create_prices_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%prices}}', [
			'id' => $this->primaryKey()->unsigned()->notNull(),
			'month_id' => $this->integer(11)->unsigned()->notNull(),
			'raw_type_id' => $this->integer(11)->unsigned()->notNull(),
			'tonnage_id' => $this->integer(11)->unsigned()->notNull(),
			'price' => $this->tinyInteger(3)->unsigned()->notNull(),
			'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
			'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP'),
		]);

		$this->addForeignKey('fk-prices-month_id', 'prices', 'month_id', 'months', 'id', 'NO ACTION', 'CASCADE');
		$this->addForeignKey('fk-prices-raw_type_id', 'prices', 'raw_type_id', 'raw_types', 'id', 'NO ACTION', 'CASCADE');
		$this->addForeignKey('fk-prices-tonnage_id', 'prices', 'tonnage_id', 'tonnages', 'id', 'NO ACTION', 'CASCADE');

		$this->execute("
		INSERT INTO prices (month_id, raw_type_id, tonnage_id, price)
		SELECT 
			 m.id AS month_id, 
			 r.id AS raw_type_id,
			 t.id AS tonnage_id,  
			 FLOOR(100 + RAND() * 100)
		FROM tonnages t
		JOIN months m
		JOIN raw_types r;
  		");
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropForeignKey('fk-prices-month_id', 'prices');
		$this->dropForeignKey('fk-prices-raw_type_id', 'prices');
		$this->dropForeignKey('fk-prices-tonnage_id', 'prices');
		$this->dropTable('{{%prices}}');
	}
}