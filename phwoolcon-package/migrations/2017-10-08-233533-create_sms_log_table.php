<?php

use Phalcon\Db\Adapter\Pdo as Adapter;
use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phwoolcon\Cli\Command\Migrate;

return [
    'up'   => function (Adapter $db, Migrate $migrate) {
        $db->createTable($table = 'sms_log', null, [
            'columns' => [
                new Column('id', [
                    'type'     => Column::TYPE_BIGINTEGER,
                    'size'     => 20,
                    'unsigned' => true,
                    'notNull'  => true,
                    'primary'  => true,
                ]),
                new Column('adapter', [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 50,
                    'notNull' => true,
                ]),
                new Column('mobile', [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 20,
                    'notNull' => true,
                ]),
                new Column('content', [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 255,
                    'notNull' => true,
                ]),
                new Column('status', [
                    'type'    => Column::TYPE_INTEGER,
                    'size'    => 1,
                    'notNull' => false,
                ]),
                new Column('status_code', [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 50,
                    'notNull' => true,
                    'default' => '',
                ]),
                new Column('status_message', [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 50,
                    'notNull' => true,
                    'default' => '',
                ]),
                new Column('extra_data', [
                    'type'    => Column::TYPE_TEXT,
                    'notNull' => false,
                ]),
                new Column('exception', [
                    'type'    => Column::TYPE_TEXT,
                    'notNull' => false,
                ]),
                new Column('created_at', [
                    'type'     => Column::TYPE_BIGINTEGER,
                    'size'     => 20,
                    'unsigned' => true,
                    'notNull'  => true,
                ]),
                new Column('updated_at', [
                    'type'     => Column::TYPE_BIGINTEGER,
                    'size'     => 20,
                    'unsigned' => true,
                    'notNull'  => false,
                ]),
            ],
            'indexes' => [
                new Index('mobile', ['mobile']),
            ],
            'options' => [
                'TABLE_COLLATION' => $migrate->getDefaultTableCharset(),
            ],
        ]);
    },
    'down' => function (Adapter $db, Migrate $migrate) {
        $db->tableExists($table = 'sms_log') and $db->dropTable($table);
    },
];
