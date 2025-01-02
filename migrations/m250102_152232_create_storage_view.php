<?php

use yii\db\Migration;

/**
 * Class m250102_152232_create_storage_view
 */
class m250102_152232_create_storage_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            create view storage_view as
            select `s`.*,
                   sum(`sp`.`price` * `sp`.`amount`)                                     AS `income`,
                   sum(`sp`.`cost_price` * `sp`.`amount`)                                AS `cost_price`,
                   sum(`sp`.`price` * `sp`.`amount` - `sp`.`cost_price` * `sp`.`amount`) AS `profit`,
                   sum(if(`p`.`unit` = 'шт', `sp`.`amount`, 0))                          AS `sht`,
                   sum(if(`p`.`unit` = 'кг', `sp`.`amount`, 0))                          AS `kg`
            from ((`storage` `s` left join `storage_product` `sp`
                   on (`s`.`id` = `sp`.`storage_id`)) left join `product` `p` on (`sp`.`product_id` = `p`.`id`))
            group by `s`.`id`
            order by `s`.`id` desc
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("drop view if exists storage_view");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250102_152232_create_storage_view cannot be reverted.\n";

        return false;
    }
    */
}
