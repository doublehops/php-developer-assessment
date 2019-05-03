<?php
/*
* DotDev - PHP Developer Test
* Author: Damien Buttler
* Date Completed:
* Time taken: 0h 0m
* Remarks:
*   - Modules
*     - Curly braces on class and method declarations have been put on a new line to adhere to PSR-2 standard.
*     - Removed casting StoreData objects to arrays to allow usage of the many PHP array funtions. I see 
*           no see case to have them cast as objects in this application.
*   - Errors
*/

class StoreData
{
    const RETURN_SORT_BY_HIGHEST_VALUE = 1;
    const RETURN_SORT_BY_DATE = 1;
    const RETURN_FILTER_WITHOUT_ITEMS = 1;

    function __construct()
    {

    }

    public function loadData ()
    {
        $customers = [
            ['id' => 'BQYLCQ0CCwIOBgYNBAcACw', 'name' => 'Bob'],
            ['id' => 'CQwPDAkDDAQLBQsOBAcMBw', 'name' => 'Jan'],
            ['id' => 'AgsIBAsFAwYCCw8GBAINAQ', 'name' => 'Steve'],
            ['id' => 'DAEFDQwPDwMCCwULBAAMDg', 'name' => 'Fred'],
            ['id' => 'DQkCAAYHAAMJBA4LBAUOCg', 'name' => 'Robot']
        ];
        $orders = [
            ['id' => 'DwsNDQ4JDQEEBQIJBAwNBA', 'customerId' => 'BQYLCQ0CCwIOBgYNBAcACw', 'dateOrdered' => 1506476504],
            ['id' => 'DwsPBQ0BAA0BBwwMBAoECA', 'customerId' => 'BQYLCQ0CCwIOBgYNBAcACw', 'dateOrdered' => 1506480104],
            ['id' => 'DAEFCwUAAgQPAQIIBA4IBA', 'customerId' => 'CQwPDAkDDAQLBQsOBAcMBw', 'dateOrdered' => 1506562904],
            ['id' => 'BAUNCAUAAQYMDgULBAMDAQ', 'customerId' => 'CgUDCQ8IDAsIBwUBBAgIAA', 'dateOrdered' => 1507081304],
            ['id' => 'DAMGAg8GCggLBwkJBAoECg', 'customerId' => 'AgsIBAsFAwYCCw8GBAINAQ', 'dateOrdered' => 1509068504],
            ['id' => 'CQALBwoDAw0AAQgHBAEJBQ', 'customerId' => 'DAEFDQwPDwMCCwULBAAMDg', 'dateOrdered' => 1538012504]
        ];
        $order_items = [
            ['id' => 'DwsNDQ4JDQEEBQIJBAwNBA', 'items' => [
                'id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 10.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73',
                'id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,   'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36',
                'id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 101.00, 'name' => 'ecbdb882ae865a07d87611437fda0772'
                ]
            ],
            ['id' => 'DwsPBQ0BAA0BBwwMBAoECA', 'items' => [
                'id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 90.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73',
                'id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,   'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36',
                'id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 101.00, 'name' => 'ecbdb882ae865a07d87611437fda0772'
                ]
            ],
            ['id' => 'DAEFCwUAAgQPAQIIBA4IBA', 'items' => [
                'id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 3.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73',
                'id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,  'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36',
                'id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 15.00, 'name' => 'ecbdb882ae865a07d87611437fda0772'
                ]
            ],
            ['id' => 'BAUNCAUAAQYMDgULBAMDAQ', 'items' => [
                'id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 10.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73',
                'id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,   'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36',
                'id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 101.00, 'name' => 'ecbdb882ae865a07d87611437fda0772'
                ]
            ],
            ['id' => 'DAMGAg8GCggLBwkJBAoECg', 'items' => [
                'id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 32.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73',
                'id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,   'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36',
                'id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 101.00, 'name' => 'ecbdb882ae865a07d87611437fda0772'
                ]
            ]
        ];
    }

    public function formatData ($option)
    {
        // All data should be returned as formatted JSON.
        if ($option == StoreData::RETURN_SORT_BY_HIGHEST_VALUE) {
            // return orders sorted by highest value. Be sure to include the order total in the response
        } elseif ($option = 2) {
            // return orders sorted by date
        } elseif ($option = 3) {
            // return orders without items
        }
        print 'DotDev';
    }
}

if (count($argv) != 2) {
    echo "Usage: The script expects the `option` parameter to be passed in.\n\n";
    exit;
}

$option = (int) $argv[1];

// Check that option passed in is a valid value.
if (!in_array($option, [StoreData::RETURN_SORT_BY_HIGHEST_VALUE,
                        StoreData::RETURN_SORT_BY_DATE,
                        StoreData::RETURN_FILTER_WITHOUT_ITEMS,
   ])) {
    echo "Error: This passed in option must be a value of either 1, 2 or 3.\n\n";
    exit;
}


$run = new StoreData();
$run->formatData($option);
