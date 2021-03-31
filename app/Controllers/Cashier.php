<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductPriceModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\POSWModel;

class Cashier extends BaseController
{
    protected $helpers = ['form', 'generate_uuid'];
    private const BESTSELLER_PRODUCT_LIMIT = 8;
    private const PRODUCT_LIMIT = 50;

    public function __construct()
    {
        $this->session = session();
        $this->product_model = new ProductModel();
        $this->product_price_model = new ProductPriceModel();
        $this->transaction_model = new TransactionModel();
        $this->transaction_detail_model = new TransactionDetailModel();
    }

    private function remapDataProduct(array $products_db, bool $return_product_ids=false): ? array
    {
        $fmt = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
        $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);

        $product_ids = [];
        $products = [];
        foreach ($products_db as $index => $val) {
            // if product id exists in products ids
            if (in_array($val['produk_id'], $product_ids)) {
                // add product price to product exists in products array
                $products[array_search($val['produk_id'], $product_ids)]['product_price'][] = [
                    'product_price_id' => $val['harga_produk_id'],
                    'product_magnitude' => $val['besaran_produk'],
                    'product_price_formatted' => $fmt->formatCurrency($val['harga_produk'], 'IDR'),
                    'product_price' => $val['harga_produk']
                ];

            } else {
                // note product id to product_ids variabel, for fast check is product exists in products array
                $product_ids[] = $val['produk_id'];

                // add new data product
                $products[] = [
                    'product_price' => [
                        [
                            'product_price_id' => $val['harga_produk_id'],
                            'product_magnitude' => $val['besaran_produk'],
                            'product_price_formatted' => $fmt->formatCurrency($val['harga_produk'], 'IDR'),
                            'product_price' => $val['harga_produk']
                        ],
                    ],
                    'product_id' => $val['produk_id'],
                    'product_name' => $val['nama_produk'],
                    'product_photo' => $val['foto_produk'],
                    'category_name' => $val['nama_kategori_produk'],
                    'product_sale' => $val['jumlah_produk']
                ];
            }
        }

        if ($return_product_ids === true) {
            return ['products' => $products, 'product_ids' => $product_ids];
        }
        return $products;
    }

    public function index()
    {
        // get bestseller products and product_ids, product ids for ignore product when get other products
        ['products' => $bestseller_products, 'product_ids' => $product_ids] = $this->remapDataProduct(
            $this->product_model->getBestsellerProducts(static::BESTSELLER_PRODUCT_LIMIT), true
        );

        // get other products
        $products_db = $this->remapDataProduct($this->product_model->getProductsForCashier($product_ids, static::PRODUCT_LIMIT));

        $data['bestseller_products'] = $bestseller_products;
        $data['products_db'] = $products_db;
        $data['product_total'] = $this->product_model->countAllProductForCashier();
        $data['product_limit'] = static::PRODUCT_LIMIT;
        $data['bestseller_product_limit'] = static::BESTSELLER_PRODUCT_LIMIT;

        return view('cashier/cashier', $data);
    }

    public function showProductSearches()
    {
        $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);
        // get products
        $products_db = $this->remapDataProduct($this->product_model->getProductSearchesForCashier(static::PRODUCT_LIMIT, $keyword));

        // get product search total
        $product_search_total = $this->product_model->countAllProductSearchForCashier($keyword);

        return json_encode([
            'products_db' => $products_db,
            'product_search_total' => $product_search_total,
            'product_limit' => static::PRODUCT_LIMIT,
            'csrf_value' => csrf_hash()
        ]);
    }

    private function buyProductTransaction(int $product_qty): string
    {
        $product_price_id = $this->request->getPost('product_price_id', FILTER_SANITIZE_STRING);

        // if exists session transaction status
        if (isset($_SESSION['posw_transaction_status'])) {
            // add product to transaction detail
            $insert_transaction_detail = $this->transaction_detail_model->insertReturning([
                'transaksi_detail_id' => generate_uuid(),
                'transaksi_id' => $_SESSION['posw_transaction_id'],
                'harga_produk_id' => $product_price_id,
                'jumlah_produk' => $product_qty
            ], 'transaksi_detail_id');
            $transaction_detail_id = $this->transaction_detail_model->getInsertReturned();

            if ($insert_transaction_detail === true) {
                return json_encode(['success'=>true, 'transaction_detail_id'=>$transaction_detail_id, 'csrf_value'=>csrf_hash()]);
            }

            return json_encode(['success'=>false, 'csrf_value'=>csrf_hash()]);

        } else {
            // if exists not transaction yet
            $transaction_id = $this->transaction_model->getNotTransactionYetId();
            if ($transaction_id !== null) {
                // create session
                $data_session = [
                    'posw_transaction_status' => 'not yet',
                    'posw_transaction_id' => $transaction_id
                ];
                $this->session->set($data_session);

                // add product to transaction detail
                $insert_transaction_detail = $this->transaction_detail_model->insertReturning([
                    'transaksi_detail_id' => generate_uuid(),
                    'transaksi_id' => $transaction_id,
                    'harga_produk_id' => $product_price_id,
                    'jumlah_produk' => $product_qty
                ], 'transaksi_detail_id');
                $transaction_detail_id = $this->transaction_detail_model->getInsertReturned();

                if ($insert_transaction_detail === true) {
                    return json_encode(['success'=>true, 'transaction_detail_id'=>$transaction_detail_id, 'csrf_value'=>csrf_hash()]);
                }

                return json_encode(['success'=>false, 'csrf_value'=>csrf_hash()]);
            }
            // if not exists not transaction yet
            else {
                $this->transaction_model->db->transStart();
                // create transaction
                $insert_transaction = $this->transaction_model->insertReturning([
                    'transaksi_id' => generate_uuid(),
                    'pengguna_id' => $_SESSION['posw_user_id'],
                    'status_transaksi' => 'belum'
                ], 'transaksi_id');
                $inserted_transaction_id = $this->transaction_model->getInsertReturned();

                // add product to transaction detail
                $insert_transaction_detail = $this->transaction_detail_model->insertReturning([
                    'transaksi_detail_id' => generate_uuid(),
                    'transaksi_id' => $inserted_transaction_id,
                    'harga_produk_id' => $product_price_id,
                    'jumlah_produk' => $product_qty
                ], 'transaksi_detail_id');
                $transaction_detail_id = $this->transaction_detail_model->getInsertReturned();

                $this->transaction_model->db->transComplete();

                if ($insert_transaction === true && $insert_transaction_detail === true) {
                    // create session
                    $data_session = [
                        'posw_transaction_status' => 'not yet',
                        'posw_transaction_id' => $inserted_transaction_id
                    ];
                    $this->session->set($data_session);

                    return json_encode(['success'=>true, 'transaction_detail_id'=>$transaction_detail_id, 'csrf_value'=>csrf_hash()]);
                }

                return json_encode(['success'=>false, 'csrf_value'=>csrf_hash()]);
            }
        }
    }

    private function buyProductRollbackTransaction(string $transaction_id, int $product_qty): string
    {
        // add product to transaction detail
        $insert_transaction_detail = $this->transaction_detail_model->insertReturning([
            'transaksi_detail_id' => generate_uuid(),
            'transaksi_id' => $transaction_id,
            'harga_produk_id' => $this->request->getPost('product_price_id', FILTER_SANITIZE_STRING),
            'jumlah_produk' => $product_qty
        ], 'transaksi_detail_id');
        $transaction_detail_id = $this->transaction_detail_model->getInsertReturned();

        if ($insert_transaction_detail === true) {
            return json_encode(['success'=>true, 'transaction_detail_id'=>$transaction_detail_id, 'csrf_value'=>csrf_hash()]);
        }

        return json_encode(['success'=>false, 'csrf_value'=>csrf_hash()]);
    }

    public function buyProduct()
    {
        $product_qty = (int)$this->request->getPost('product_qty', FILTER_SANITIZE_STRING);
        // if product qty = 0
        if ($product_qty <= 0) {
            return false;
        }

        // if file backup exists
        if (file_exists(WRITEPATH.'transaction_backup/data.json')) {
            ['transaction_id' => $transaction_id] = json_decode(file_get_contents(WRITEPATH.'transaction_backup/data.json'), true);
            return $this->buyProductRollbackTransaction($transaction_id, $product_qty);
        }

        return $this->buyProductTransaction($product_qty);
    }

    private function getTransactionDetailsInTransaction(): string
    {
        // if exists session transaction status
        if (isset($_SESSION['posw_transaction_status'])) {
            $transaction_details = $this->transaction_detail_model->getTransactionDetailsForCashier(
                $_SESSION['posw_transaction_id'],
                'produk.produk_id, transaksi_detail_id, nama_produk, harga_produk, besaran_produk, jumlah_produk'
            );

            return json_encode([
                'transaction_details' => $transaction_details,
                'type' => 'transaction',
                'csrf_value' => csrf_hash()
            ]);
        }

        // if exists not transaction yet
        $transaction_id = $this->transaction_model->getNotTransactionYetId();
        if ($transaction_id !== null) {
            $transaction_details = $this->transaction_detail_model->getTransactionDetailsForCashier(
                $transaction_id,
                'produk.produk_id, transaksi_detail_id, nama_produk, harga_produk, besaran_produk, jumlah_produk'
            );

            // create session
            $data_session = [
                'posw_transaction_status' => 'not yet',
                'posw_transaction_id' => $transaction_id
            ];
            $this->session->set($data_session);

            return json_encode([
                'transaction_details' => $transaction_details,
                'type' => 'transaction',
                'csrf_value' => csrf_hash()
            ]);
        }
        return json_encode(['transaction_details'=>null, 'csrf_value'=>csrf_hash()]);
    }

    private function getTransactionDetailsInRollbackTransaction(string $transaction_id): string
    {
        $customer_money = $this->transaction_model->findTransaction($transaction_id, 'uang_pembeli')['uang_pembeli']??null;
        $transaction_details = $this->transaction_detail_model->getTransactionDetailsForCashier(
            $transaction_id,
            'produk.produk_id, transaksi_detail_id, nama_produk, harga_produk, besaran_produk, jumlah_produk'
        );

        return json_encode([
            'customer_money' => $customer_money,
            'transaction_details' => $transaction_details,
            'type' => 'rollback-transaction',
            'csrf_value' => csrf_hash()
        ]);
    }

    public function showTransactionDetails()
    {
        // if file backup exists
        if (file_exists(WRITEPATH.'transaction_backup/data.json')) {
            ['transaction_id' => $transaction_id] = json_decode(file_get_contents(WRITEPATH.'transaction_backup/data.json'), true);
            return $this->getTransactionDetailsInRollbackTransaction($transaction_id);
        }

        return $this->getTransactionDetailsInTransaction();
    }

    public function updateProductQty()
    {
        $transaction_detail_id = $this->request->getPost('transaction_detail_id', FILTER_SANITIZE_STRING);
        $product_qty_new = (int)$this->request->getPost('product_qty_new', FILTER_SANITIZE_STRING);

        // if product qty new <= 0
        if ($product_qty_new <= 0) {
            return false;
        }

        // generate transaction id
        if (isset($_SESSION['posw_transaction_id'])) {
            $transaction_id = $_SESSION['posw_transaction_id'];
        } else {
            ['transaction_id' => $transaction_id] = json_decode(file_get_contents(WRITEPATH.'transaction_backup/data.json'), true);
        }

        $this->transaction_detail_model->updateProductQty($transaction_detail_id, $product_qty_new, $transaction_id);
        return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
    }

    public function removeProductFromShoppingCart()
    {
        $transaction_detail_id = $this->request->getPost('transaction_detail_id', FILTER_SANITIZE_STRING);

        // generate transaction id
        if (isset($_SESSION['posw_transaction_id'])) {
            $transaction_id = $_SESSION['posw_transaction_id'];
        } else {
            ['transaction_id' => $transaction_id] = json_decode(file_get_contents(WRITEPATH.'transaction_backup/data.json'), true);
        }

        // remove product
        $this->transaction_detail_model->removeTransactionDetail($transaction_detail_id, $transaction_id);
        return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
    }

    public function finishTransaction()
    {
        if (!$this->validate([
            'customer_money' => [
                'label' => 'Uang Pembeli',
                'rules' => 'required|integer|max_length[10]',
                'errors' => $this->generateIndoErrorMessages(['required','integer','max_length'])
            ]
        ])) {
            return json_encode(['success'=>false, 'form_errors'=>$this->validator->getErrors(), 'csrf_value'=>csrf_hash()]);
        }

        $customer_money = $this->request->getPost('customer_money', FILTER_SANITIZE_NUMBER_INT);
        // update customer money in db and update status transaction
        $this->transaction_model->update($_SESSION['posw_transaction_id'], [
            'uang_pembeli' => $customer_money,
            'status_transaksi' => 'selesai',
            'waktu_buat' => date('Y-m-d H:i:s')
        ]);

        // remove session status transaction
        $this->session->remove(['posw_transaction_id', 'posw_transaction_status']);

        return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
    }

    public function cancelTransaction()
    {
        // remove transaction and will automatic remove transaction detail related to transaction
        $this->transaction_model->delete($_SESSION['posw_transaction_id']);
        // remove session status transaction
        $this->session->remove(['posw_transaction_id', 'posw_transaction_status']);

        return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
    }

    public function showTransactionsThreeDaysAgo()
    {
        $timestamp_three_days_ago = date('Y m d H:i:s', mktime(00, 00, 00, date('m'), date('d'), date('Y')) - (60 * 60 * 24 * 3));
        $transactions_three_days_ago = $this->transaction_model->getTransactionsThreeDaysAgo($timestamp_three_days_ago);

        // convert timestamp
        $indo_time = new \App\Libraries\IndoTime();
        $count_transaction_three_days_ago = count($transactions_three_days_ago);

        for($i = 0; $i < $count_transaction_three_days_ago; $i++) {
            $transactions_three_days_ago[$i]['waktu_buat'] = $indo_time->toIndoLocalizedString(
                $transactions_three_days_ago[$i]['waktu_buat']
            );
        }

        return json_encode(['transactions_three_days_ago' => $transactions_three_days_ago, 'csrf_value'=>csrf_hash()]);
    }

    public function showTransactionDetailsThreeDaysAgo()
    {
        $transaction_id = $this->request->getPost('transaction_id', FILTER_SANITIZE_STRING);
        // change transaction status
        $this->transaction_model->update($transaction_id, [
            'status_transaksi' => 'belum'
        ]);

        // get customer money and transaction detail
        $customer_money = $this->transaction_model->findTransaction($transaction_id, 'uang_pembeli')['uang_pembeli']??null;
        $transaction_details = $this->transaction_detail_model->getTransactionDetailsForCashier(
            $transaction_id,
            'produk.produk_id, harga_produk.harga_produk_id, transaksi_detail_id, nama_produk, harga_produk, besaran_produk, jumlah_produk'
        );

        // backup transaction and transaction detail to json file
        $data_backup = json_encode(['transaction_id'=>$transaction_id, 'transaction_details'=>$transaction_details]);
        file_put_contents(WRITEPATH.'transaction_backup/data.json', $data_backup);

        return json_encode(['customer_money'=>$customer_money, 'transaction_details'=>$transaction_details, 'csrf_value'=>csrf_hash()]);
    }

    private function generateTransactionDetailIdsNotInBackup(array $transaction_details_backup, array $transaction_detail_ids): array
    {
        $results = [];
        foreach ($transaction_detail_ids as $tdi) {
            $exists = false;
            foreach ($transaction_details_backup as $tdb) {
                // transaction detail id = data backup transaction detail id
                if ($tdi === $tdb['transaksi_detail_id']) {
                    $exists = true;
                    break;
                }
            }

            // if exists = false, this mean transaction detail id not exists in backup
            if ($exists === false) {
                $results[] = $tdi;
            }
        }
        return $results;
    }

    private function generateDataResetTransactionDetail(array $transaction_details, string $transaction_id): array
    {
        $data_reset = [];
        foreach($transaction_details as $td) {
            $data_reset[] = [
                'transaksi_detail_id' => $td['transaksi_detail_id'],
                'transaksi_id' => $transaction_id,
                'harga_produk_id' => $td['harga_produk_id'],
                'jumlah_produk' => $td['jumlah_produk']
            ];
        }
        return $data_reset;
    }

    public function cancelRollbackTransaction()
    {
        if (file_exists(WRITEPATH.'transaction_backup/data.json')) {
            // get transaction id and transaction details in backup file
            [
                'transaction_id' => $transaction_id,
                'transaction_details' => $transaction_details
            ] = json_decode(file_get_contents(WRITEPATH.'transaction_backup/data.json'), true);

            // remove transaction detail not exists in backup file
            $transaction_detail_ids = $this->request->getPost('transaction_detail_ids', FILTER_SANITIZE_STRING);
            if (!empty(trim($transaction_detail_ids))) {
                $transaction_detail_ids_not_in_backup = $this->generateTransactionDetailIdsNotInBackup(
                    $transaction_details,
                    explode(',', $transaction_detail_ids)
                );
            } else {
                $transaction_detail_ids_not_in_backup = [];
            }

            if (count($transaction_detail_ids_not_in_backup) > 0) {
                $this->transaction_detail_model->removeTransactionDetails($transaction_detail_ids_not_in_backup, $transaction_id);
            }

            // if exists transaction details
            if (count($transaction_details) > 0) {
                // reset transaction detail
                $data_reset = $this->generateDataResetTransactionDetail(
                    $transaction_details,
                    $transaction_id
                );
                $this->transaction_detail_model->saveTransactionDetails($data_reset);
            }

            // update status transaction = selesai
            $this->transaction_model->update($transaction_id, [
                'status_transaksi' => 'selesai'
            ]);

            // remove file backup
            unlink(WRITEPATH.'transaction_backup/data.json');
            return json_encode(['success'=>true, 'transaction_details'=>$transaction_details, 'csrf_value'=>csrf_hash()]);
        }
    }

    public function finishRollbackTransaction()
    {
        if (!$this->validate([
            'customer_money' => [
                'label' => 'Uang Pembeli',
                'rules' => 'required|integer|max_length[10]',
                'errors' => $this->generateIndoErrorMessages(['required','integer','max_length'])
            ]
        ])) {
            return json_encode(['success'=>false, 'form_errors'=>$this->validator->getErrors(), 'csrf_value'=>csrf_hash()]);
        }

        ['transaction_id' => $transaction_id] = json_decode(file_get_contents(WRITEPATH.'transaction_backup/data.json'), true);
        $customer_money = $this->request->getPost('customer_money', FILTER_SANITIZE_NUMBER_INT);
        // update customer money, created time and update status transaction
        $this->transaction_model->update($transaction_id, [
            'uang_pembeli' => $customer_money,
            'status_transaksi' => 'selesai',
            'waktu_buat' => date('Y-m-d H:i:s')
        ]);

        // if exists file backup
        if (file_exists(WRITEPATH.'transaction_backup/data.json')) {
            // remove file backup
            unlink(WRITEPATH.'transaction_backup/data.json');
        }

        return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
    }
}
