<?php

use yii\db\Migration;

/**
 * Class m220919_051547_create_shop_product_main_photo_field
 */
class m220919_051547_create_shop_product_main_photo_field extends Migration
{
    public function up()
    {
        $this->addColumn(
            '{{%shop_products}}',
            'main_photo_id', $this->integer()
        );

        $this->createIndex(
            '{{%idx-shop_products-main_photo_id}}',
            '{{%shop_products}}',
            'main_photo_id'
        );

        $this->addForeignKey(
            '{{%fk-shop_products-main_photo_id}}',
            '{{%shop_products}}',
            'main_photo_id',
            '{{%shop_photos}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            '{{%fk-shop_products-main_photo_id}}',
            '{{%shop_products}}'
        );

        $this->dropColumn(
            '{{%shop_products}}',
            'main_photo_id'
        );
    }
}
