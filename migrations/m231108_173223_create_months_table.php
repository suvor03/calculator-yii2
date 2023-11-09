<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%months}}`.
 */
class m231108_173223_create_months_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%months}}', [
			'id' => $this->primaryKey()->unsigned()->notNull(),
			'name' => $this->string(10)->notNull()->unique(),
			'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
			'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP'),
		]);

		$this->batchInsert('{{%months}}', ['name'], [
			['Январь'],
			['Февраль'],
			['Март'],
			['Апрель'],
			['Май'],
			['Июнь'],
			['Июль'],
			['Август'],
			['Сентябрь'],
			['Октябрь'],
			['Ноябрь'],
			['Декабрь']
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%months}}');
	}
}