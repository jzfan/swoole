<?php

$table = new Swoole\Table(1024);

$table->column('id', $table::TYPE_INT, 4);
$table->column('name', $table::TYPE_STRING, 20);
$table->column('email', $table::TYPE_STRING, 20);
$table->create();

$table->set('admin', ['id'=>1, 'name'=>'superman', 'email'=>'admin@example.com']);

$admin = $table->get('admin');

print_r($admin);