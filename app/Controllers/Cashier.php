<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\ProductPriceModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\POSWModel;
use App\Libraries\ValidationMessage;

class Cashier extends Controller
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

    private function remapDataProducts(array $products_db, bool $return_product_ids=false): ? array
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
                    'product_sales' => $val['jumlah_produk']
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
        $bestseller_products_remapped = $this->remapDataProducts($this->product_model->getBestsellerProducts(static::BESTSELLER_PRODUCT_LIMIT), true);
        $bestseller_products = $bestseller_products_remapped['products'];
        $product_ids = $bestseller_products_remapped['product_ids'];

        $products_remapped = $this->remapDataProducts($this->product_model->getProductsForCashier($product_ids, static::PRODUCT_LIMIT));

        $data['bestseller_products'] = $bestseller_products;
        $data['products_db'] = $products_remapped;
        $data['product_total'] = $this->product_model->countAllProductForCashier();
        $data['product_limit'] = static::PRODUCT_LIMIT;
        $data['bestseller_product_limit'] = static::BESTSELLER_PRODUCT_LIMIT;

        return view('cashier/cashier', $data);
    }

    public function showProductSearches()
    {
        $keyword = $this->request->getPost('keyword', FILTER_SANITIZE_STRING);
        $product_remapped = $this->remapDataProducts($this->product_model->getProductSearchesForCashier(static::PRODUCT_LIMIT, $keyword));

        // get product search total
        $product_search_total = $this->product_model->countAllProductSearchForCashier($keyword);

        echo json_encode([
            'products_db' => $product_remapped,
            'product_search_total' => $product_search_total,
            'product_limit' => static::PRODUCT_LIMIT,
            'csrf_value' => csrf_hash()
        ]);
        return true;
    }

    public function buyProduct()
    {
        $product_price_id = $this->request->getPost('product_price_id', FILTER_SANITIZE_STRING);
        $product_qty = (int)$this->request->getPost('product_qty', FILTER_SANITIZE_STRING);

        // if product qty = 0
        if ($product_qty <= 0) {
            return false;
        }

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

            if ($insert_transaction_detail > 0) {
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

                if ($insert_transaction_detail > 0) {
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
                    'status_transaksi' => 'belum',
                    'waktu_buat' => date('Y-m-d H:i:s')
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

                if ($insert_transaction === true && $insert_transaction_detail > 0) {
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

    public function showTransactionDetail()
    {
        // if exists session transaction status
        if (isset($_SESSION['posw_transaction_status'])) {
            $transaction_detail = $this->transaction_detail_model->getTransactionDetailForCashier(
                $_SESSION['posw_transaction_id'],
                'produk.produk_id, transaksi_detail_id, nama_produk, harga_produk, besaran_produk, jumlah_produk'
            );
            return json_encode(['transaction_detail'=>$transaction_detail, 'csrf_value'=>csrf_hash()]);
        }

        // if exists not transaction yet
        $transaction_id = $this->transaction_model->getNotTransactionYetId();
        if ($transaction_id !== null) {
            $transaction_detail = $this->transaction_detail_model->getTransactionDetailForCashier(
                $transaction_id,
                'produk.produk_id, transaksi_detail_id, nama_produk, harga_produk, besaran_produk, jumlah_produk'
            );

            // create session
            $data_session = [
                'posw_transaction_status' => 'not yet',
                'posw_transaction_id' => $transaction_id
            ];
            $this->session->set($data_session);

            return json_encode(['transaction_detail'=>$transaction_detail, 'csrf_value'=>csrf_hash()]);
        }
        return json_encode(['transaction_detail'=>[], 'csrf_value'=>csrf_hash()]);
    }

    public function updateProductQty()
    {
        $transaction_detail_id = $this->request->getPost('transaction_detail_id', FILTER_SANITIZE_STRING);
        $product_qty_new = (int)$this->request->getPost('product_qty_new', FILTER_SANITIZE_STRING);

        // if product qty new <= 0
        if ($product_qty_new <= 0) {
            return false;
        }

        $this->transaction_detail_model->updateProductQty($transaction_detail_id, $product_qty_new);
        return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
    }

    public function removeProductFromShoppingCart()
    {
        $transaction_detail_id = $this->request->getPost('transaction_detail_id', FILTER_SANITIZE_STRING);
        $this->transaction_detail_model->removeTransactionDetail($transaction_detail_id);

        return json_encode(['success'=>true, 'csrf_value'=>csrf_hash()]);
    }

    public function finishTransaction()
    {
        if (!$this->validate([
            'customer_money' => [
                'label' => 'Uang Pembeli',
                'rules' => 'required|integer|max_length[10]',
                'errors' => ValidationMessage::generateIndonesianErrorMessage('required','integer','max_length')
            ]
        ])) {
            return json_encode(['success'=>false, 'form_errors'=>$this->validator->getErrors(), 'csrf_value'=>csrf_hash()]);
        }

        $customer_money = $this->request->getPost('customer_money', FILTER_SANITIZE_NUMBER_INT);
        // save customer money in db and update status transaction
        $this->transaction_model->update($_SESSION['posw_transaction_id'], [
            'uang_pembeli' => $customer_money,
            'status_transaksi' => 'selesai'
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
}
