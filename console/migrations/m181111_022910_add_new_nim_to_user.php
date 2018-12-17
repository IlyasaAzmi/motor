<?php

use yii\db\Migration;

/**
 * Class m181111_022910_add_new_nim_to_user
 */
class m181111_022910_add_new_nim_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    // public function safeUp()
    // {
    //
    // }
    //
    // /**
    //  * {@inheritdoc}
    //  */
    // public function safeDown()
    // {
    //     echo "m181111_022910_add_new_nim_to_user cannot be reverted.\n";
    //
    //     return false;
    // }

    public function up()
    {
        $this->addColumn('{{%user}}', 'nim', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'nim');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181111_022910_add_new_nim_to_user cannot be reverted.\n";

        return false;
    }
    */
}
