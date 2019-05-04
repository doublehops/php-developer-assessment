<?php
/*
* DotDev - PHP Developer Test
* Author: Damien Buttler
* Date Completed:
* Time taken: 3h 0m
* Remarks:
*   - Modules
*   - Errors
*     - The order item data items were not declared as individual arrays, resulting the each one being overwritten by the last.
*
*   - Notes
*     - Using constants for allowed input parameters to make the code mode readable.
*     - Curly braces on class and method declarations have been put on a new line to adhere to PSR-2 standard.
*     - Modified casting of StoreData data from objects to arrays to allow usage of the many PHP array funtions. I see 
*           no see case to have them cast as objects in this application.
*     - The application is to be run from the shell. This command will format the output into JSON to make it readable:
*          php assessment.php 3 | python -m json.tool
*/

class StoreData
{
    const RETURN_SORT_BY_HIGHEST_VALUE = 1;
    const RETURN_SORT_BY_DATE = 2;
    const RETURN_FILTER_WITHOUT_ITEMS = 3;

    protected $customers;
    protected $orders;
    protected $order_items;

    function __construct()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->customers = [
            ['id' => 'BQYLCQ0CCwIOBgYNBAcACw', 'name' => 'Bob'],
            ['id' => 'CQwPDAkDDAQLBQsOBAcMBw', 'name' => 'Jan'],
            ['id' => 'AgsIBAsFAwYCCw8GBAINAQ', 'name' => 'Steve'],
            ['id' => 'DAEFDQwPDwMCCwULBAAMDg', 'name' => 'Fred'],
            ['id' => 'DQkCAAYHAAMJBA4LBAUOCg', 'name' => 'Robot']
        ];

        $this->orders = [
            ['id' => 'DwsNDQ4JDQEEBQIJBAwNBA', 'customerId' => 'BQYLCQ0CCwIOBgYNBAcACw', 'dateOrdered' => 1506476504],
            ['id' => 'DwsPBQ0BAA0BBwwMBAoECA', 'customerId' => 'BQYLCQ0CCwIOBgYNBAcACw', 'dateOrdered' => 1506480104],
            ['id' => 'DAEFCwUAAgQPAQIIBA4IBA', 'customerId' => 'CQwPDAkDDAQLBQsOBAcMBw', 'dateOrdered' => 1506562904],
            ['id' => 'BAUNCAUAAQYMDgULBAMDAQ', 'customerId' => 'CgUDCQ8IDAsIBwUBBAgIAA', 'dateOrdered' => 1507081304],
            ['id' => 'DAMGAg8GCggLBwkJBAoECg', 'customerId' => 'AgsIBAsFAwYCCw8GBAINAQ', 'dateOrdered' => 1509068504],
            ['id' => 'CQALBwoDAw0AAQgHBAEJBQ', 'customerId' => 'DAEFDQwPDwMCCwULBAAMDg', 'dateOrdered' => 1538012504]
        ];

        $this->order_items = [
            ['id' => 'DwsNDQ4JDQEEBQIJBAwNBA', 'items' => [
                    ['id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 10.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73'],
                    ['id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,   'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36'],
                    ['id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 101.00, 'name' => 'ecbdb882ae865a07d87611437fda0772']
                ]
            ],
            ['id' => 'DwsPBQ0BAA0BBwwMBAoECA', 'items' => [
                    ['id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 90.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73'],
                    ['id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,   'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36'],
                    ['id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 101.00, 'name' => 'ecbdb882ae865a07d87611437fda0772']
                ]
            ],
            ['id' => 'DAEFCwUAAgQPAQIIBA4IBA', 'items' => [
                    ['id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 3.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73'],
                    ['id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,  'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36'],
                    ['id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 15.00, 'name' => 'ecbdb882ae865a07d87611437fda0772']
                ]
            ],
            ['id' => 'BAUNCAUAAQYMDgULBAMDAQ', 'items' => [
                    ['id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 10.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73'],
                    ['id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,   'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36'],
                    ['id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 101.00, 'name' => 'ecbdb882ae865a07d87611437fda0772']
                ]
            ],
            ['id' => 'DAMGAg8GCggLBwkJBAoECg', 'items' => [
                    ['id' => 'CgkCDwwDDgYODgYFBAwKAQ', 'value' => 32.00,  'name' => 'b0a8b6f820479900e34d34f6b8a4af73'],
                    ['id' => 'DQcJBAYFCAoCBAYJBAIGDQ', 'value' => 0.55,   'name' => 'cf3298bb5cbfd41aa44ba18b4f305a36'],
                    ['id' => 'BwEOBwgNDQ4NCQkHBA8IDA', 'value' => 101.00, 'name' => 'ecbdb882ae865a07d87611437fda0772']
                ]
            ]
        ];
    }

    /**
     * Get order items by order id.
     *
     * @param string orderId
     * @return array
     */
    protected function getOrderItemsByOrderId($orderId)
    {
        $key = array_search($orderId, array_column($this->order_items, 'id'));

        if ($key === false) {
            return [];
        }

        return $this->order_items[$key]['items'];
    }

    /**
     * Find customer by id.
     *
     * @param string $customerId
     * @return array
     */
    protected function getCustomerById($customerId)
    {
        $key = array_search($customerId, array_column($this->customers, 'id'));

        if ($key === false) {
            return [];
        }

        return $this->customers[$key];
    }

    /**
     * Get orders by highest value.
     *
     * @return array
     */
    protected function getOrdersByHighestValue()
    {
        $orders = $this->addOrderTotalOrders($this->orders, $this->order_items);
        $orders = $this->sortOrdersByTotal($orders);

        return $orders;
    }

    /**
     * Get orders by date.
     *
     * @return array
     */
    protected function getOrdersByDate()
    {
        $orders = $this->sortOrdersByDate($this->orders);

        return $orders;
    }

    /**
     * Get orders that have no items.
     *
     * @return array
     */
    protected function getOrdersWithoutItems()
    {
        $orders = [];

        foreach ($this->orders as $order) {
            $key = array_search($order['id'], array_column($this->order_items, 'id'));

            if ($key === false) {
                $orders[] = $order;
            }
        }

        return $orders;
    }

    /**
     * Sort orders by their date.
     *
     * @param array $orders
     * @return array
     */
    protected function sortOrdersByDate($orders)
    {
        usort($orders, function ($item2, $item1) {
            return $item2['dateOrdered'] <=> $item1['dateOrdered'];
        });

        return $orders;
    }

    /**
     * Sort orders by their total.
     *
     * @param array $orders
     * @return array
     */
    protected function sortOrdersByTotal($orders)
    {
        usort($orders, function ($item2, $item1) {
            return $item1['total'] <=> $item2['total'];
        });

        return $orders;
    }

    /**
     * Get order values.
     *
     * @param array $orders
     * @param array $order_items
     * @return array
     */
    protected function addOrderTotalOrders($orders, $order_items)
    {
        $updatedOrders = [];

        foreach ($orders as $order) {
            $orderTotal = 0;
            $orderItems = $this->getOrderItemsByOrderId($order['id']);
            foreach ($orderItems as $item) {
                $orderTotal += $item['value'];
            }
            $order['total'] = $orderTotal;
            $updatedOrders[] = $order;
        }

        return $updatedOrders;
    }

    /**
     * Format data according to option supplied. Return output in JSON format.
     *
     * @param integer $option
     */
    public function formatData($option)
    {
        // All data should be returned as formatted JSON.
        if ($option == self::RETURN_SORT_BY_HIGHEST_VALUE) {
            // return orders sorted by highest value. Be sure to include the order total in the response
            $data = $this->getOrdersByHighestValue();
        } elseif ($option == self::RETURN_SORT_BY_DATE) {
            // return orders sorted by date
            $data = $this->getOrdersByDate();
        } elseif ($option == self::RETURN_FILTER_WITHOUT_ITEMS) {
            // return orders without items
            $data = $this->getOrdersWithoutItems();
        }

        $this->outputData($data);
    }

    /**
     * Format data to the expected format and output.
     *
     * @param array $orders
     */
    protected function outputData($orders)
    {
        $output = [];

        foreach ($orders as $order) {
            $output[$order['id']] = ['date' => $order['dateOrdered'],
                                     'total' => $order['total'] ?? 0,
                                     'customer' => $this->getCustomerById($order['customerId']),
                                     'order_items' => $this->getOrderItemsByOrderId($order['id']),
            ];
        }

        echo json_encode($output);
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
