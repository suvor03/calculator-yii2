<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tonnages}}`.
 */
class m231108_173334_create_tonnages_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%tonnages}}', [
			'id' => $this->primaryKey()->unsigned()->notNull(),
			'value' => $this->tinyInteger(3)->unsigned()->notNull()->unique(),
			'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
			'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP'),
		]);

		$this->batchInsert('tonnages', ['value'], [
			[25],
			[50],
			[75],
			[100]
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%tonnages}}');
	}
}