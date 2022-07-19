<?php

use \yii\db\Migration;

class m190124_110202_add_email_confirm_token_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique()->after('email'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'email_confirm_token');
    }
}
