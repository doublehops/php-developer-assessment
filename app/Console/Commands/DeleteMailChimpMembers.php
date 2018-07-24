<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class DeleteMailChimpMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailchimp:delete:members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete MailChimp Members';

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
        $md5Emails = $this->getExcelEmailsWithMd5();

        $mailUrl = env('MailChimp_URL');
        $mailListNumber = env('MailChimp_list_number');

        $client = new Client();
        foreach($md5Emails as $md5Email) {
            try {
                $response = $client->request('DELETE', $mailUrl.$mailListNumber.'members/'.$md5Email, ['auth' => ['Face Helo', env('MailChimp_API_KEY')]]);
                $resultData = $response->getBody()->getContents();
                $formatData = json_decode($resultData);
                if($formatData == null){
                    $this->info('MailChimp Member id '. $md5Email.' Deleted!');
                }else{
                    $this->info('errors: MailChimp Member id '. $md5Email.' can not Deleted!');
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function getExcelEmailsWithMd5(){
        $md5Data = [];
        try {
            $filePath = '/Users/dotdev/Downloads/ROW_Customer_List.csv';
            $content = file_get_contents($filePath);

            $lines = explode("\r", $content);
            unset($lines[0]);

            foreach($lines as $line){
                $line = str_replace("\n","",$line);
                $md5Encrypt = md5(strtolower($line));
                array_push($md5Data, $md5Encrypt);
            }
            return $md5Data;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
