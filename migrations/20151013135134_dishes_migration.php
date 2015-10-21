<?php

use Phinx\Migration\AbstractMigration;

class DishesMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        
        $dishes = $this->table('dishes');
        $dishes->addColumn('title', 'string',array('limit' => 250))
            ->addColumn('description', 'text')
            ->addColumn('categoryId', 'integer')
            ->addColumn('cost', 'decimal',array('precision'=>5,'scale'=>2))
            ->addColumn('created', 'timestamp')
            ->addColumn('updated', 'timestamp')
            ->save();


        $dishesMedia=$this->table('dishes_media');
        $dishesMedia->addColumn('dishId','integer',array('null'=>false))
            ->addColumn('mediaId','biginteger',array('limit'=>20, 'null'=>false))
            ->addForeignKey('dishId','dishes','id',array('delete'=>'CASCADE','update'=>'NO_ACTION'))
            ->addForeignKey('mediaId','media','id',array('delete'=>'CASCADE','update'=>'NO_ACTION'))
            ->save();


    }
}
