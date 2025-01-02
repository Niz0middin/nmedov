<?php

use yii\db\Migration;

/**
 * Class m250102_152223_create_report_view
 */
class m250102_152223_create_report_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            create view report_view as
            select `r`.*,
                   sum(`rp`.`price` * `rp`.`amount`)                                                     AS `income`,
                   sum(`rp`.`cost_price` * `rp`.`amount`)                                                AS `cost_price`,
                   sum(`rp`.`price` * `rp`.`amount` - `rp`.`cost_price` * `rp`.`amount`) - `r`.`expense` AS `profit`,
                   sum(if(`p`.`unit` = 'шт', `rp`.`amount`, 0))                                          AS `sht`,
                   sum(if(`p`.`unit` = 'кг', `rp`.`amount`, 0))                                          AS `kg`
            from ((`report` `r` left join `report_product` `rp`
                   on (`r`.`id` = `rp`.`report_id`)) left join `product` `p` on (`rp`.`product_id` = `p`.`id`))
            group by `r`.`id`
            order by `r`.`id` desc
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("drop view if exists report_view");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250102_152223_create_report_view cannot be reverted.\n";

        return false;
    }
    */
}
