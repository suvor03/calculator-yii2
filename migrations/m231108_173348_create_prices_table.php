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
			'month_name' => $this->string(10)->unsigned()->notNull(),
			'raw_type_name' => $this->string(10)->unsigned()->notNull(),
			'tonnage_value' => $this->tinyInteger(3)->unsigned()->notNull(),
			'price' => $this->tinyInteger(3)->unsigned()->notNull(),
			'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
			'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP'),
		]);

		$this->addForeignKey('fk-prices-month_name', 'prices', 'month_name', 'months', 'name', 'NO ACTION', 'CASCADE');
		$this->addForeignKey('fk-prices-raw_type_name', 'prices', 'raw_type_name', 'raw_types', 'name', 'NO ACTION', 'CASCADE');
		$this->addForeignKey('fk-prices-tonnage_value', 'prices', 'tonnage_value', 'tonnages', 'value', 'NO ACTION', 'CASCADE');

		$this->execute("
		INSERT INTO prices (month_name, raw_type_name, tonnage_value, price)
		SELECT 
			 m.name AS month_name, 
			 r.name AS raw_type_name,
			 t.value AS tonnage_value,  
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
		$this->dropForeignKey('fk-prices-month_name', 'prices');
		$this->dropForeignKey('fk-prices-raw_type_name', 'prices');
		$this->dropForeignKey('fk-prices-tonnage_value', 'prices');
		$this->dropTable('{{%prices}}');
	}
}