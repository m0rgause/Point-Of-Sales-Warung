<?php

namespace App\Models;

class TransactionModel extends BaseModel
{
	protected $table = 'transaksi';
	protected $primaryKey = 'transaksi_id';
    protected $allowedFields = ['transaksi_id', 'pengguna_id', 'status_transaksi', 'waktu_buat', 'uang_pembeli'];
    protected $useAutoIncrement = false;

    public function getNotTransactionYetId(): ? string
    {
        return $this->select('transaksi_id')
                    ->getWhere(['status_transaksi' => 'belum', 'pengguna_id' => $_SESSION['posw_user_id']])
                    ->getRowArray()['transaksi_id']??null;
    }

    public function getTransactionThreeDaysAgo(string $timestamp_three_days_ago): array
    {
        return $this->select('transaksi_id, waktu_buat')
                    ->getWhere(['waktu_buat >=' => $timestamp_three_days_ago, 'pengguna_id' => $_SESSION['posw_user_id']])
                    ->getResultArray();
    }
}
