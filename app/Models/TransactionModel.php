<?php

namespace App\Models;

class TransactionModel extends BaseModel
{
	protected $table = 'transaksi';
	protected $primaryKey = 'transaksi_id';
    protected $allowedFields = ['transaksi_id', 'pengguna_id', 'status_transaksi', 'waktu_buat', 'uang_pembeli'];
    protected $useAutoIncrement = false;

    public function getTransactions(string $limit): array
    {
        return $this->select('
                        transaksi.transaksi_id,
                        status_transaksi,
                        transaksi.waktu_buat,
                        nama_lengkap,
                        SUM(harga_produk*jumlah_produk) as payment_total'
                    , false)
                    ->selectSum('jumlah_produk', 'product_total')
                    ->join('transaksi_detail', 'transaksi.transaksi_id=transaksi_detail.transaksi_id', 'LEFT')
                    ->join('harga_produk', 'transaksi_detail.harga_produk_id=harga_produk.harga_produk_id', 'lEFT')
                    ->join('pengguna', 'transaksi.pengguna_id=pengguna.pengguna_id', 'INNER')
                    ->limit($limit)->groupBy(['transaksi.transaksi_id', 'nama_lengkap'])->orderBy('transaksi.waktu_buat', 'DESC')
                    ->get()->getResultArray();
    }

    public function countAllTransaction(): int
    {
        return $this->select('transaksi_id')->get()->getNumRows();
    }

    public function getNotTransactionYetId(): ? string
    {
        return $this->select('transaksi_id')
                    ->getWhere(['status_transaksi' => 'belum', 'pengguna_id' => $_SESSION['posw_user_id']])
                    ->getRowArray()['transaksi_id']??null;
    }

    public function getTransactionsThreeDaysAgo(string $timestamp_three_days_ago): array
    {
        return $this->select('transaksi_id, waktu_buat')
                    ->orderBy('waktu_buat', 'desc')
                    ->getWhere(['waktu_buat >=' => $timestamp_three_days_ago, 'pengguna_id' => $_SESSION['posw_user_id']])
                    ->getResultArray();
    }

    public function findTransaction(string $transaction_id, string $column): ? array
    {
        return $this->select($column)
                    ->getWhere(['transaksi_id' => $transaction_id])
                    ->getRowArray();
    }
}
