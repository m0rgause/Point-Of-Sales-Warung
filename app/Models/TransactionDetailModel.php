<?php

namespace App\Models;

class TransactionDetailModel extends BaseModel
{
	protected $table = 'transaksi_detail';
	protected $primaryKey = 'transaksi_detail_id';
    protected $allowedFields = ['transaksi_detail_id', 'transaksi_id', 'harga_produk_id', 'jumlah_produk'];
    protected $useAutoIncrement = false;

    public function getTransactionDetailForCashier(string $transaction_id, string $column): array
    {
        return $this->select($column)
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
            $values[] = $d;
        }
        return $values;
    }

    public function saveTransactionDetail(array $data_save)
    {
        $this->generateColumns($data_save[0]);
        $this->generateQueryUpdateOnConflict($data_save[0]);
        $this->generateQuestionMarksBatch($data_save);
        return $this->generateValuesBatch($data_save);

        $query = "INSERT INTO transaksi_detail(transaksi_detail_id, transaksi_id, harga_produk_id, jumlah_produk)
            VALUES
            ('a96729f9-0584-4306-93f8-1a68412cd263', '53051d3a-d4e2-49cd-8991-61c021c6ea05', '764a1913-0c91-4c84-ada6-db3b12e4bdf0', '1'),
            ('c274415a-58a1-4613-89d0-0ce80eaefde8', '53051d3a-d4e2-49cd-8991-61c021c6ea05', '7369c1a2-ffd4-4892-becc-377aebfab3f1', '1'),
            ('9fe21ecc-de76-4ec2-980a-36a56c8c0f08', '53051d3a-d4e2-49cd-8991-61c021c6ea05', '6113c939-6021-4a79-b638-79050a2cf4a2', '2'),
            ('08d23ffe-3e4e-4325-8dae-364de9e7cd9a', '53051d3a-d4e2-49cd-8991-61c021c6ea05', '0c4d0743-6bdc-440b-afe3-4f680e463083', '4'),
            ('7a8ebb15-1d07-4396-8231-1462e9c0b54c', '53051d3a-d4e2-49cd-8991-61c021c6ea05', 'e75667ee-0f24-4700-ae6e-64ed67c63fb2', '2')
ON CONFLICT (transaksi_detail_id) DO UPDATE SET transaksi_id = EXCLUDED.transaksi_id, harga_produk_id = EXCLUDED.harga_produk_id, jumlah_produk = EXCLUDED.jumlah_produk";
    }
}
