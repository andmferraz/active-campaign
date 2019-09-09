<?php

require __DIR__ . "/../vendor/autoload.php";

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class ActiveCampaign
{
    // CREDENTIALS
    private $acUrl;
    private $acKey;

    // RESOURCES - CLIENT
    private $acSource;
    private $client;    

    public function __construct() 
    {        
        $this->acUrl = 'https://account.api-us1.com/api/3'; // URL
        $this->acKey = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; // Chave        

        $this->client = new \GuzzleHttp\Client([
            "base_uri" => $this->acUrl,
            "timeout"  => 2.0
        ]);
    }
    
    /**
     * CREATE A CONNECTION
     * @param STR $connectionService The name of the service. (required)     
     * @param STR $connectionExternalid The id of the account in the external service. (required)
     * @param STR $connectionName The name associated with the account in the external service. Often this will be a company name (e.g., 'My Toystore, Inc.'). (required)
     * @param STR $connectionLogoUrl The URL to a logo image for the external service. (required)
     * @param STR $connectionLinkUrl The URL to a page where the integration with the external service can be managed in the third-party's website. (required)     
    */
    public function createConnection($connectionService, $connectionExternalid, $connectionName, $connectionLogoUrl, $connectionLinkUrl)
    {
        try
        {
            $options = [
                'json' => [
                    "connection" => [
                        "service"    => $connectionService,
                        "externalid" => $connectionExternalid,
                        "name"       => $connectionName,
                        "logoUrl"    => $connectionLogoUrl,
                        "linkUrl"    => $connectionLinkUrl
                    ]
                ]
            ]; 
            $response = $this->client->post("/api/3/connections?api_key=" . $this->acKey, $options);            
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):                
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * RETRIEVE A CONNECTION
    * @param INT connection Id (required)
    */
    public function retrieveConnection($Id)
    {
        try
        {            
            $url = $this->acUrl . "/connections/" . $Id . "?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):                
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * UPDATE A CONNECTION
    * @param INT connection Id (required)
    */
    public function updateConnection($Id, $connectionService, $connectionExternalid, $connectionName, $connectionLogoUrl, $connectionLinkUrl, $connectionStatus, $connectionSyncStatus)
    {
        try
        {
            $options = [
                'json' => [
                    "connection" => [
                        "service"    => $connectionService,
                        "externalid" => $connectionExternalid,
                        "name"       => $connectionName,
                        "logoUrl"    => $connectionLogoUrl,
                        "linkUrl"    => $connectionLinkUrl,
                        "status"     => $connectionStatus,
                        "syncStatus" => $connectionSyncStatus
                    ]
                ]
            ]; 
            $response = $this->client->put("/api/3/connections/" . $Id . "?api_key=" . $this->acKey, $options);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * DELETE A CONNECTION
    * @param INT connection Id (required)
    */
    public function deleteConnection($Id)
    {
        try
        {
            $response = $this->client->delete("/api/3/connections/" . $Id . "?api_key=" . $this->acKey);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * LIST ALL CONNECTIONS
    */
    public function listConnections()
    {
        try
        {
            $url = $this->acUrl . "/connections?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * CREATE A CUSTOMER
    * @param STR $connectionid The id of the connection object for the service where the customer originates. (required)
    * @param STR $externalid The id of the customer in the external service. (required)
    * @param STR $email The email address of the customer. (required)
    * @param STR $acceptsMarketing Indication of whether customer has opt-ed in to marketing communications. 0 = not opted-in, 1 = opted-in. A value of 0 means the contact will match the "Has not opted in to marketing" segment condition and a value of 1 means the contact will match the "Has opted in to marketing" segment condition. (optional)
    */
    public function createCustomer($connectionid, $externalid, $email, $acceptsMarketing)
    {
        try
        {
            $options = [
                'json' => [
                    "ecomCustomer" => [
                        "connectionid"     => $connectionid,
                        "externalid"       => $externalid,
                        "email"            => $email,
                        "acceptsMarketing" => $acceptsMarketing
                    ]
                ]
            ];             
            $response = $this->client->post("/api/3/ecomCustomers?api_key=" . $this->acKey, $options);
            return $result = json_decode($response->getBody());            
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):                
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * RETRIEVE A CUSTOMER
    * @param INT customer Id (required)
    */
    public function retrieveCustomer($Id)
    {
        try
        {            
            $url = $this->acUrl . "/ecomCustomers/" . $Id . "?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());            
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * UPDATE A CUSTOMER
    * @param INT customer Id (required)
    */
    public function updateCustomer($Id, $customerEmail, $customerAcceptsMarketing)
    {
        try
        {
            $options = [
                'json' => [
                    "ecomCustomer" => [
                        "externalid"       => $Id,                        
                        "email"            => $customerEmail,
                        "acceptsMarketing" => $customerAcceptsMarketing
                    ]
                ]
            ]; 
            $response = $this->client->put("/api/3/ecomCustomers/" . $Id . "?api_key=" . $this->acKey, $options);            
            return json_decode($response->getBody());
        }
        catch (RequestException $e) {       
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * DELETE A CUSTOMER
    * @param INT customer Id (required)
    */
    public function deleteCustomer($Id)
    {
        try
        {
            $response = $this->client->delete("/api/3/ecomCustomers/" . $Id . "?api_key=" . $this->acKey);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * LIST ALL CUSTOMERS
    */
    public function listCustomers()
    {
        try
        {
            $url = $this->acUrl . "/ecomCustomers?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }    

    /**
    * CREATE AN ORDER
    * @param STR $externalid The id of the order in the external service. (ONLY REQUIRED IF EXTERNALCHECKOUTID NOT INCLUDED)
    * @param STR $externalcheckoutid The id of the cart in the external service. (ONLY REQUIRED IF EXTERNALID IS NOT INCLUDED.)
    * @param INT $source The order source code (0 - sync, 1 - realtime webhook). (optional)
    * @param STR $email The email address of the customer who placed the order. (required)    
    * @param ARRAY $orderProducts Products Order
    * @param STR $orderProductsName The name of the product (required)
    * @param INT $orderProductsPrice The price of the product, in cents. (i.e. $456.78 => 45678). Must be greater than or equal to zero. (required)
    * @param INT $orderProductsQuantity The quantity ordered. (required)    
    * @param INT $orderProductsExternalid The id of the product in the external service. (required)    
    * @param STR $orderProductsCategory The category of the product. (optional)
    * @param STR $orderProductsSku The SKU for the product (optional)
    * @param STR $orderProductsDescription The description of the product (optional)
    * @param STR $orderProductsImageUrl An Image URL that displays an image of the product (optional)
    * @param STR $orderProductsUrl A URL linking to the product in your store (optional)    
    * @param STR $totalPrice The total price of the order in cents, including tax and shipping charges. (i.e. $456.78 => 45678). Must be greater than or equal to zero. (required)
    * @param STR $shippingAmount The total shipping amount in cents for the order. (optional)
    * @param STR $taxAmount The total tax amount for the order in cents. (optional)
    * @param STR $discountAmount The total discount amount for the order in cents. (optional)
    * @param STR $currency The currency of the order (3-digit ISO code, e.g., 'USD'). (required)
    * @param INT $connectionid The id of the connection from which this order originated. (required)
    * @param INT $customerid The id of the customer associated with this order. (required) 
    * @param STR $orderUrl The URL for the order in the external service. (optional)
    * @param DATE $externalCreatedDate The date the order was placed. (required)
    * @param STR $externalUpdatedDate The date the order was updated.(optional)
    * @param STR $externalUpdatedDate The date the cart was abandoned. REQUIRED ONLY IF INCLUDING EXTERNALCHECKOUTID.
    * @param STR $shippingMethod The shipping method of the order. (optional)
    * @param STR $orderNumber The order number. This can be different than the externalid. (optional)
    */
    public function createOrder($externalid, $source, $email, array $orderProducts, $orderUrl, $externalCreatedDate, $externalUpdatedDate, $shippingMethod, $totalPrice, $shippingAmount, $taxAmount, $discountAmount, $currency, $connectionid, $customerid)
    {
        try
        {                
            $options = [
                'json' => [                    
                    "ecomOrder" => [
                        "externalid"          => $externalid,
                        "source"              => $source,
                        "email"               => $email,
                        "orderProducts"       => $orderProducts,
                        "orderUrl"            => $orderUrl,
                        "externalCreatedDate" => $externalCreatedDate, // required
                        "externalUpdatedDate" => $externalUpdatedDate,
                        "shippingMethod"      => $shippingMethod,
                        "totalPrice"          => $totalPrice,
                        "shippingAmount"      => $shippingAmount,
                        "taxAmount"           => $taxAmount,                        
                        "discountAmount"      => $discountAmount,
                        "currency"            => $currency, // required
                        "connectionid"        => $connectionid, // required
                        "customerid"          => $customerid, // required
                    ]
                ]
            ];            
            $response = $this->client->post("/api/3/ecomOrders?api_key=" . $this->acKey, $options);            
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * RETRIEVE AN ORDER
    * @param INT order Id (required)
    */
    public function retrieveOrder($Id)
    {
        try
        {            
            $url = $this->acUrl . "/ecomOrders/" . $Id . "?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * DELETE AN ORDER
    * @param INT order Id (required)
    */
    public function deleteOrder($Id)
    {
        try
        {
            $response = $this->client->delete("/api/3/ecomOrders/" . $Id . "?api_key=" . $this->acKey);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * LIST ALL ORDERS
    */
    public function listOrders()
    {
        try
        {
            $url = $this->acUrl . "/ecomOrders?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * UPDATE AN ORDER
    * @param STR $externalid The id of the order in the external service. (ONLY REQUIRED IF EXTERNALCHECKOUTID NOT INCLUDED)        
    * @param STR $email The email address of the customer who placed the order. (required)    
    * @param ARRAY $orderProducts Products Order    
    * @param STR $externalUpdatedDate The date the order was updated.(optional)
    * @param STR $shippingMethod The shipping method of the order. (optional)
    * @param STR $totalPrice The total price of the order in cents, including tax and shipping charges. (i.e. $456.78 => 45678). Must be greater than or equal to zero. (required)
    * @param STR $shippingAmount The total shipping amount in cents for the order. (optional)
    * @param STR $taxAmount The total tax amount for the order in cents. (optional)
    * @param STR $discountAmount The total discount amount for the order in cents. (optional)
    * @param STR $currency The currency of the order (3-digit ISO code, e.g., 'USD'). (required)
    * @param STR $orderNumber The order number. This can be different than the externalid. (optional)    
    */
    public function updateOrder()
    {
        try
        {
            $options = [
                'json' => [
                    "ecomOrder" => [
                        "externalid"          => $externalid,                                                
                        "email"               => $email,                        
                        "orderProducts"       => $orderProducts,
                        "externalUpdatedDate" => $externalUpdatedDate,
                        "shippingMethod"      => $shippingMethod,
                        "totalPrice"          => $totalPrice,
                        "shippingAmount"      => $shippingAmount,
                        "taxAmount"           => $taxAmount,
                        "discountAmount"      => $discountAmount,
                        "currency"            => $currency,
                        "orderNumber"         => $orderNumber
                    ]
                ]
            ]; 
            $response = $this->client->put("/api/3/ecomOrders/" . $Id . "?api_key=" . $this->acKey, $options);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * CREATE AN ABANDONED CART    
    * @param STR $externalcheckoutid The id of the cart in the external service. (ONLY REQUIRED IF EXTERNALID IS NOT INCLUDED.)
    * @param INT $source The order source code (0 - sync, 1 - realtime webhook). (optional)
    * @param STR $email The email address of the customer who placed the order. (required)    
    * @param ARRAY $orderProducts Products Order    
    * @param INT $totalPrice The total price of the order in cents, including tax and shipping charges. (i.e. $456.78 => 45678). Must be greater than or equal to zero. (required)
    * @param INT $shippingAmount The total shipping amount in cents for the order. (optional)
    * @param INT $taxAmount The total tax amount for the order in cents. (optional)
    * @param INT $discountAmount The total discount amount for the order in cents. (optional)
    * @param STR $currency The currency of the order (3-digit ISO code, e.g., 'USD'). (required)
    * @param INT $connectionid The id of the connection from which this order originated. (required)
    * @param INT $customerid The id of the customer associated with this order. (required) 
    * @param STR $orderUrl The URL for the order in the external service. (optional)
    * @param DATE $externalCreatedDate The date the order was placed. (required)
    * @param STR $externalUpdatedDate The date the order was updated.(optional)
    * @param STR $externalUpdatedDate The date the cart was abandoned. REQUIRED ONLY IF INCLUDING EXTERNALCHECKOUTID.
    * @param STR $shippingMethod The shipping method of the order. (optional)
    * @param STR $orderNumber The order number. This can be different than the externalid. (optional)
    * @param DATE $abandoned_date Date the cart was abandoned (required)
    */
    public function createAbandonedCart($externalcheckoutid, $source, $email, array $orderProducts, $orderUrl, $externalCreatedDate, $externalUpdatedDate, $abandonedDate, $totalPrice, $currency, $connectionid, $customerid)
    {
        try
        {                
            $options = [
                'json' => [                    
                    "ecomOrder" => [                        
                        "externalcheckoutid"  => $externalcheckoutid,
                        "source"              => $source,
                        "email"               => $email,
                        "orderProducts"       => $orderProducts,
                        "orderUrl"            => $orderUrl,
                        "externalCreatedDate" => $externalCreatedDate, // required
                        "externalUpdatedDate" => $externalUpdatedDate,
                        "abandonedDate"       => $abandonedDate,
                        "totalPrice"          => $totalPrice,
                        "currency"            => $currency, // required
                        "connectionid"        => $connectionid, // required
                        "customerid"          => $customerid // required                        
                    ]
                ]
            ];            
            $response = $this->client->post("/api/3/ecomOrders?api_key=" . $this->acKey, $options);            
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * LIST ITEMS PRODUCTS
    */
    public function listOrderProducts()
    {
        try
        {
            $url = $this->acUrl . "/ecomOrderProducts?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * LIST ITEMS PRODUCTS FOR A SPECIFIC ORDER
    */
    public function listOrderProductsId($Id)
    {
        try
        {
            $url = $this->acUrl . "/ecomOrders/{$Id}/orderProducts?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

    /**
    * LIST PRODUCT FOR A SPECIFIC ORDER
    */
    public function listOrderProduct($Id)
    {
        try
        {
            $url = $this->acUrl . "/ecomOrderProducts/{$Id}?api_key=" . $this->acKey;
            $response = $this->client->request('GET', $url);
            return $result = json_decode($response->getBody());
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            if(isset($response)):
                return $response->getBody()->getContents();
            endif;
        }
    }

}
