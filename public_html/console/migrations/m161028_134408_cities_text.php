<?php

use yii\db\Migration;

class m161028_134408_cities_text extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('cities_text', [
            'id' => $this->primaryKey()->unsigned(),
            'cities_id' => $this->integer()->unsigned()->notNull(),
            'languages_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull(),
            'application_url' => $this->string()->null(),
            'name_rp' => $this->string(),
            'name_pp' => $this->string(),
        ], $tableOptions);

        $this->createIndex('idx_ct_application_url', 'cities_text', 'application_url');
        $this->createIndex('idx_ct_cities_id', 'cities_text', 'cities_id');
        $this->addForeignKey('fk_cities_text_city', 'cities_text', 'cities_id', 'cities', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_ct_languages_id', 'cities_text', 'languages_id');
        $this->addForeignKey('fk_cities_text_language', 'cities_text', 'languages_id', 'languages', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_cities_text_city','cities_text');
        $this->dropIndex('idx_ct_cities_id','cities_text');
        $this->dropForeignKey('fk_cities_text_language','cities_text');
        $this->dropIndex('idx_ct_languages_id','cities_text');
        $this->dropTable('cities_text');
    }

}
