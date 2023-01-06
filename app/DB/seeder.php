<?php

$admins = [
    ['name' => 'Silvestras', 'email' => 'silvestras.stalone@gmail.com', 'psw' => md5('silvestras123')],
    ['name' => 'Mantas', 'email' => 'mantas.krisciunas@gmail.com', 'psw' => md5('mantas123')],
    ['name' => 'Monika', 'email' => 'monika.levickaite@gmail.com', 'psw' => md5('monika123')]
];

$users = [
    ['id' => 1, 'id_num' => '39502150645', 'bank_acc' => 'LT01 6249 9798 0123 4567', 'name' => 'Tomas', "surname" => 'Blaževičius', 'money' => 2695],
    ['id' => 2, 'id_num' => '38709251195', 'bank_acc' => 'LT56 6249 9986 4562 0066', 'name' => 'Eglė', "surname" => 'Kaminskaitė', 'money' => 1399],
    ['id' => 3, 'id_num' => '39502150645', 'bank_acc' => 'LT44 6249 9032 8569 7741', 'name' => 'Matas', "surname" => 'Vieversys', 'money' => 14822]
];

$id = 3;

file_put_contents(__DIR__ . '/admins', serialize($admins));
file_put_contents(__DIR__ . '/users', serialize($users));
file_put_contents(__DIR__ . '/users_id', serialize($id));
