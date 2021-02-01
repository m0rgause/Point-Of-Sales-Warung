<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    public $table = 'produk';
    protected $primaryKey = 'produk_id';
    protected $allowedFields = ['kategori_produk_id','nama_produk','foto_produk','status_produk','waktu_buat'];

    public function getProducts(int $limit, int $offset): array
    {
        return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                    ->orderBy('waktu_buat', 'DESC')->limit($limit, $offset)->get()->getResultArray();
    }

    public function getProductSearches(int $limit, int $offset, string $match): array
    {
        return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                    ->orderBy('waktu_buat', 'DESC')->limit($limit, $offset)
                    ->like('nama_produk',$match,'after')->get()->getResultArray();
    }

    public function countAllProduct(): int
    {
        return count($this->select('produk_id')->get()->getResultArray());
    }

    public function countAllProductSearch(string $match): int
    {
        return count($this->select('produk_id')->like('nama_produk',$match,'after')->get()->getResultArray());
    }

    public function findProduct(string $product_id, string $column): ? array
    {
        return $this->select($column)->getWhere(['produk_id'=>$product_id])->getRowArray();
    }

    public function removeProduct(array $product_ids): bool
    {
        try {
            $this->whereIn('produk_id', $product_ids)->delete();
            return true;
        } catch (\ErrorException $e) {
            return false;
        }
    }

    public function getLongerProducts(int $limit, string $smallest_create_time): array
    {
        return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                    ->limit($limit)->orderBy('waktu_buat', 'DESC')->getWhere(['waktu_buat <' => $smallest_create_time])
                    ->getResultArray();
    }

    public function getLongerProductSearches(int $limit, string $smallest_create_time, string $match)
    {
         return $this->select('produk_id,nama_produk,status_produk,waktu_buat')
                     ->limit($limit)->orderBy('waktu_buat', 'DESC')->like('nama_produk',$match,'after')
                     ->getWhere(['waktu_buat <' => $smallest_create_time])->getResultArray();
    }

    public function findProducts(array $product_ids, string $column): array
    {
        return $this->select($column)->whereIn('produk_id', $product_ids)->get()->getResultArray();
    }

    public function getBestsellerProducts(int $limit): array
    {
        return $this->query("SELECT p.produk_id, p.nama_produk, p.foto_produk, p.nama_kategori_produk,
                                    hp.harga_produk_id, hp.harga_produk, hp.besaran_produk, p.jumlah_produk FROM
            (
                SELECT p.nama_produk, p.foto_produk, p.produk_id,
                       (SELECT kp.nama_kategori_produk FROM kategori_produk kp WHERE kp.kategori_produk_id=p.kategori_produk_id) nama_kategori_produk,
                       SUM(td.jumlah_produk) jumlah_produk
                FROM produk p
                INNER JOIN harga_produk hp USING(produk_id)
                LEFT JOIN transaksi_detail td USING(harga_produk_id)
                WHERE p.status_produk='ada' AND jumlah_produk IS NOT NULL AND p.produk_id IS NOT NULL
                GROUP BY p.produk_id ORDER BY jumlah_produk DESC LIMIT :limit:
            ) p

            INNER JOIN harga_produk hp USING(produk_id)
            ORDER BY p.jumlah_produk DESC", ['limit' => $limit])->getResultArray();
    }

    public function getOtherProducts(? string $product_ids, int $limit)
    {
        $sql = "SELECT p.produk_id, p.nama_produk, p.foto_produk, p.nama_kategori_produk,
                                    hp.harga_produk_id, hp.harga_produk, hp.besaran_produk, p.jumlah_produk FROM
                (
                    SELECT p.waktu_buat, p.nama_produk, p.foto_produk, p.produk_id,
                           (SELECT kp.nama_kategori_produk FROM kategori_produk kp WHERE kp.kategori_produk_id=p.kategori_produk_id) nama_kategori_produk,
                           SUM(td.jumlah_produk) jumlah_produk
                    FROM produk p
                    INNER JOIN harga_produk hp USING(produk_id)
                    LEFT JOIN transaksi_detail td USING(harga_produk_id)
                    WHERE p.status_produk='ada' AND p.produk_id IS NOT NULL";

        // if exists product_ids
        if ($product_ids !== null) {
            $sql .= " AND p.produk_id NOT IN (".$product_ids.")";
        }

        $sql .= " GROUP BY p.produk_id ORDER BY p.waktu_buat DESC LIMIT :limit:
                ) p

                INNER JOIN harga_produk hp USING(produk_id)
                ORDER BY p.waktu_buat DESC";

        return $this->query($sql, ['limit' => $limit])->getResultArray();
    }
}
