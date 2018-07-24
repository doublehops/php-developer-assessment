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

        ini_set('max_execution_time', 1200);

        $store = config('faceHalo.store');
        $key = config('faceHalo.key');
        $pass = config('faceHalo.pass');
        $secret = config('faceHalo.secret');
        $faceHelo = new PrivateApp($store,$key,$pass,$secret);

        try {
            $excelEmails = $this->getExcelEmails();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        foreach($excelEmails as $excelEmail){
            try{
                $response = $faceHelo->get('customers/search', ['query' => ['query' => 'email:'.$excelEmail]]);
                $customerId = $response->customers[0]->id;

                $faceHelo->delete('customers/'.$customerId);
                $this->info('customer '. $customerId .' deleted ' . $excelEmail);
            }catch (\Exception $e){
                $this->info('errors: get shopify customers');
                continue;
            }
        }


    }

    public function getExcelEmails(){
        try {

            $filePath = 'test.csv';
            $content = file_get_contents($filePath);

            $lines = explode("\r", $content);
            return $lines;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
