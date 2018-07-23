<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\App;
use Illuminate\Console\Command;
use Shopify\PrivateApp;

class DeleteShopifyCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shopify:delete:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Shopify Customers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $deleteIDs = [];
        $idIndexer = 0;
        $filePath = __DIR__;
        $fileName = 'test.xlsx';

        $store = config('faceHalo.store');
        $key = config('faceHalo.key');
        $pass = config('faceHalo.pass');
        $secret = config('faceHalo.secret');
        $faceHelo = new PrivateApp($store,$key,$pass,$secret);

        $excelEmails = $this->getExcelEmails($filePath, $fileName);

        foreach($excelEmails as $excelEmail){
            try{
                $response = $faceHelo->get('customers/search', ['query' => ['query' => 'email:'.$excelEmail['email']]]);
                $deleteIDs[$idIndexer] = $response->customers[0]->id;
                $idIndexer++;
            }catch (\Exception $e){
                $this->info('errors: get shopify customers');
                continue;
            }
        }

        foreach($deleteIDs as $deleteID){
            try{
                $faceHelo->delete('customers/'.$deleteID);
                $this->info('customer'.$deleteID.'deleted');
            }catch (\Exception $e){
                $this->info('errors: Error deleting customer');
                continue;
            }


        }

    }

    public function getExcelEmails($fPath, $fName){
        $excel = App::make('excel');
        $filePath = __DIR__. '/Customer.xlsx';
        $excelEmails = $excel->load($filePath, function ($reader){
            $data = $reader->select(array('email'))->get();
            $collection = collect($data);
            $flattened = $collection->flatten();
            return $flattened->all();
        })->toArray();
        return $excelEmails;
    }
}
