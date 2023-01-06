<?php

function validateIDNum(array $users, string $num): bool
{
    foreach ($users as $user) {
        if ($user['id_num'] == $num) {
            return false;
        }
    }
    return true;
}

function generateIBAN(array $users, string $IBAN = ''): string
{
    $IBAN = 'LT' . rand(0, 9) . rand(0, 9) . ' ' . '6249' . ' ' . '9' . rand(0, 9) . rand(0, 9) . rand(0, 9) . ' ' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . ' ' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    foreach ($users as $user) {
        if ($user['bank_acc'] == $IBAN) {
            generateIBAN($users, $IBAN);
        }
    }
    return $IBAN;
}
