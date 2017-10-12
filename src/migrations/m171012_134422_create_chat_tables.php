<?php

use yii\db\Migration;

class m171012_134422_create_chat_tables extends Migration
{
    public function safeUp()
    {

        if (Yii::$app->db->schema->getTableSchema('{{%message}}', true) === null) {
            $this->createTable('{{%message}}', [

                'id'          => $this->bigPrimaryKey(11)->unsigned()->notNull(),
                'sender_id'   => $this->bigInteger(11)->unsigned()->notNull(),
                'receiver_id' => $this->bigInteger(11)->unsigned()->notNull(),
                'message'     => $this->string(255)->notNull(),
                'read_status' => $this->boolean()->notNull()->defaultValue(0),
                'status'      => $this->boolean()->notNull()->defaultValue(1),
                'created_at'  => $this->integer(11),
                'updated_at'  => $this->integer(11),

            ]);
            // creates index for column `sender_id`
            $this->createIndex(
                'fk_message_sender_id',
                '{{%message}}',
                'sender_id'
            );

            // add foreign key for table `sender_id`
            $this->addForeignKey(
                'fk_message_sender_id',
                '{{%message}}',
                'sender_id',
                '{{%user}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
            // creates index for column `receiver_id`
            $this->createIndex(
                'fk_message_receiver_id',
                '{{%message}}',
                'receiver_id'
            );

            // add foreign key for table `receiver_id`
            $this->addForeignKey(
                'fk_message_receiver_id',
                '{{%message}}',
                'receiver_id',
                '{{%user}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
        }
    }

    public function safeDown()
    {
        // drops foreign key for column `sender_id`
        $this->dropForeignKey(
            'fk_message_sender_id',
            '{{%message}}'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            'fk_message_sender_id',
            '{{%message}}'
        );
        // drops foreign key for column `receiver_id`
        $this->dropForeignKey(
            'fk_message_receiver_id',
            '{{%message}}'
        );

        // drops index for column `receiver_id`
        $this->dropIndex(
            'fk_message_receiver_id',
            '{{%message}}'
        );

        $this->dropTable('{{%message}}');
    }

}
