<?php

/* This helper for check is transaction three days ago or no and is transaction finish or no, in transaction page.
 * If yes then allow delete transaction.
 */

function is_transaction_allowed_delete(?string $create_time, string $transaction_status): bool
{
    $timestamp_three_days_ago = date('Y-m-d H:i:s', mktime(00, 00, 00, date('m'), date('d'), date('Y')) - (60 * 60 * 24 * 3));
    return $create_time<$timestamp_three_days_ago&&$transaction_status!=='belum';
}
