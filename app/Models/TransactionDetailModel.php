<?php

namespace App\Models;

class TransactionDetailModel extends BaseModel
{
	protected $table = 'transaksi_detail';
	protected $primaryKey = 'transaksi_detail_id';
    protected $allowedFields = ['transaksi_detail_id', 'transaksi_id', 'harga_produk_id', 'jumlah_produk'];
    protected $useAutoIncrement = false;

    public function getTransactionDetailForCashier(string $transaction_id): array
    {
        return $this->select('produk.produk_id, transaksi_detail_id, nama_produk, harga_produk, besaran_produk, jumlah_produk')
                    ->join('harga_produk', 'transaksi_detail.harga_produk_id = harga_produk.harga_produk_id')
                    ->join('produk', 'harga_produk.produk_id = produk.produk_id')
                    ->getWhere(['transaksi_id' => $transaction_id])
                    ->getResultArray();
    }

    public function updateProductQty(string $transaction_detail_id, int $product_qty_new): bool
    {
        return $this->where('transaksi_id', $_SESSION['posw_transaction_id'])
                    ->update($transaction_detail_id, ['jumlah_produk'=>$product_qty_new]);
    }

    public function removeTransactionDetail(string $transaction_detail_id): int
    {
        $this->where('transaksi_id', $_SESSION['posw_transaction_id'])
             ->delete($transaction_detail_id);
        return $this->db->affectedRows();
    }
}
