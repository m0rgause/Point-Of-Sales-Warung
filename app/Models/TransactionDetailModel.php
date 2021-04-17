<?php

namespace App\Models;

class TransactionDetailModel extends BaseModel
{
	protected $table = 'transaksi_detail';
	protected $primaryKey = 'transaksi_detail_id';
    protected $allowedFields = ['transaksi_detail_id', 'transaksi_id', 'harga_produk_id', 'jumlah_produk'];
    protected $useAutoIncrement = false;

    public function getTransactionDetailsForCashier(string $transaction_id, string $column): array
    {
        return $this->select($column)
                    ->join('harga_produk', 'transaksi_detail.harga_produk_id = harga_produk.harga_produk_id', 'INNER')
                    ->join('produk', 'harga_produk.produk_id = produk.produk_id', 'INNER')
                    ->getWhere(['transaksi_id' => $transaction_id])
                    ->getResultArray();
    }

    public function updateProductQty(string $transaction_detail_id, int $product_qty_new, string $transaction_id): bool
    {
        return $this->where('transaksi_id', $transaction_id)
                    ->update($transaction_detail_id, ['jumlah_produk'=>$product_qty_new]);
    }

    public function removeTransactionDetail(string $transaction_detail_id, string $transaction_id): int
    {
        $this->where('transaksi_id', $transaction_id)
             ->delete($transaction_detail_id);
        return $this->db->affectedRows();
    }

    public function removeTransactionDetails(array $transaction_detail_ids, string $transaction_id): int
    {
        $this->whereIn('transaksi_detail_id', $transaction_detail_ids)
             ->where('transaksi_id', $transaction_id)
             ->delete();
        return $this->db->affectedRows();
    }

    /*
     |------------------------
     | save transaction detail
     |----------------------------
     | this method will be insert if transaction detail not exists or update if exists
     */

    private function generateQueryUpdateOnConflict(array $data): string
    {
        $query = 'UPDATE SET ';
        foreach ($data as $key => $value) {
            $query .= $key.' = EXCLUDED.'.$key.', ';
        }
        return rtrim($query, ', ');
    }

    private function generateQuestionMarksBatch(array $data): string
    {
        $values = '';
        foreach ($data as $d) {
            $count_d = count($d)-1;
            $values .= '('.str_repeat('?,', $count_d).'?),';
        }
        return rtrim($values, ',');
    }

    private function generateValuesBatch(array $data): array
    {
        $values = [];
        foreach ($data as $d) {
            foreach($d as $c) {
                $values[] = $c;
            }
        }
        return $values;
    }

    public function saveTransactionDetails(array $data_save): int
    {
        $query = "INSERT INTO transaksi_detail(".$this->generateColumns($data_save[0]).")
            VALUES ".$this->generateQuestionMarksBatch($data_save)."
            ON CONFLICT (transaksi_detail_id) DO ".$this->generateQueryUpdateOnConflict($data_save[0]);
        $this->query($query, $this->generateValuesBatch($data_save));

        return $this->db->affectedRows();
    }
}
