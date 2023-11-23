<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history}}`.
 */
class m231122_092109_create_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('{{%history}}', [
			'id' => $this->primaryKey()->unsigned()->notNull(),
			'username' => $this->string(),
			'month_name' => $this->string(),
			'raw_type_name' => $this->string(),
			'tonnage_value' => $this->string(),
			'price' => $this->string(),
			'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
	  ]);
    }

    /**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%history}}');
	}
}