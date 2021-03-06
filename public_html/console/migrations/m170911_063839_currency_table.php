<?php

use yii\db\Migration;

class m170911_063839_currency_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('currencies', [
            'id' => $this->primaryKey()->unsigned(),
            'code' => $this->string()->notNull(),
            'iso_code' => $this->string()->notNull(),
            'active' => $this->boolean()->defaultValue(1)->notNull(),
            'is_default' => $this->boolean()->defaultValue(0)->notNull(),
            'symbol' => $this->string(10)->notNull(),
        ], $tableOptions);

        $this->createTable('currencies_text', [
            'id' => $this->primaryKey()->unsigned(),
            'currencies_id' => $this->integer(10)->unsigned()->notNull(),
            'languages_id' => $this->integer(10)->unsigned()->notNull(),
            'name' => $this->string(255)->notNull(),
            'name_short' => $this->string(5)->notNull(),
            'name_rp' => $this->string(255)->notNull(),
            'name_pp' => $this->string(255)->notNull(),
            'name_m' => $this->string(255)->notNull(),
            'name_m_rp' => $this->string(255)->notNull(),
            'name_m_pp' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_ct_currencies_id', 'currencies_text', 'currencies_id');
        $this->addForeignKey('fk_currencies_text_currency', 'currencies_text', 'currencies_id', 'currencies', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_ct_languages_id', 'currencies_text', 'languages_id');
        $this->addForeignKey('fk_currencies_text_language', 'currencies_text', 'languages_id', 'languages', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('countries', 'currencies_id', $this->integer()->unsigned()->null());
        $this->createIndex('idx_ci_countries', 'countries', 'currencies_id');
        $this->addForeignKey('fk_countries_currency', 'countries', 'currencies_id', 'currencies', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('currencies');

        $this->dropForeignKey('fk_currencies_text_currency','currencies_text');
        $this->dropIndex('idx_ct_currencies_id','currencies_text');
        $this->dropTable('currencies_text');
        $this->dropForeignKey('fk_currencies_text_language','currencies_text');
        $this->dropIndex('idx_ct_languages_id','currencies_text');

        $this->dropForeignKey('fk_countries_currency','countries');
        $this->dropIndex('idx_ci_countries','countries');
    }
}
