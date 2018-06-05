<?php
namespace libraries\ShopifyApiLib;

class ShopifyApiLib
{
    private $apiKey = '';
    private $apiPassword = '';
    private $publicShopUrl = '';
    private $shopUrl = '';
    private $products = array();
    private $collections = array();
    private $products2collectionRels = array();

    public function __construct()
    {
    }

    public function config($params = array())
    {
        if(empty($params['apiKey'])) { throw new \Exception("Empty api key"); } else { $this->apiKey = $params['apiKey']; }
        if(empty($params['apiPassword'])) { throw new \Exception("Empty api password"); } else { $this->apiPassword = $params['apiPassword']; }
        if(empty($params['publicShopUrl'])) { throw new \Exception("Empty public shop url"); } else { $this->publicShopUrl = $params['publicShopUrl']; }
    }

    public function createShopUrl()
    {
        $this->shopUrl = "https://{$this->apiKey}:{$this->apiPassword}@{$this->publicShopUrl}/admin/";
    }

    public function getStorefrontAccessToken()
    {
        return array(
            'access_scopes' => $this->sendRequest('oauth/access_scopes.json'),
            'storefront_access_tokens' => $this->sendRequest('storefront_access_tokens.json')
        );
    }

    public function sendRequest($to)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->shopUrl.$to);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $request = curl_exec($curl);
        curl_close($curl);

        if($request === false) {
            throw new \Exception("Api returns error");
        } else {
            $response = json_decode($request, true);
            if(isset($response['error'])) {
                throw new \Exception("Api returns error");
            } else {
                return $request;
            }
        }
    }

    public function getProducts()
    {
        try {
            $this->products = json_decode($this->sendRequest("products.json"), true);
        } catch (\Exception $exception)
        {
            return $exception->getMessage();
        }

        return $this;
    }

    public function arrangeProductsImages($images)
    {
        if(sizeof($images) > 0) {
            return $images[0]['src'];
        }
        else {
            return null;
        }
    }

    public function getProductsPrice($product)
    {
        $variants = $product['variants'][0];
        return $variants['price'];
    }


    public function arrangeProductsArray()
    {
        $arrangeProducts = array();
        foreach ($this->products['products'] as $product)
        {
            $productSubmission = array(
                'product_id' => $product['id'],
                'title' => $product['title'],
                'description' => $product['body_html'],
                'vendor' => $product['vendor'],
                'product_type' => $product['product_type'],
                'created_at' => strtotime($product['created_at']),
                'price' => $this->getProductsPrice($product),
                'image' => $this->arrangeProductsImages($product['images'])
            );
            array_push($arrangeProducts, $productSubmission);
        }
        return $arrangeProducts;
    }

    public function getCollections()
    {
        try {
            $this->collections = json_decode($this->sendRequest("smart_collections.json"), true);
        } catch (\Exception $exception)
        {
            return $exception->getMessage();
        }

        return $this;
    }

    public function arrangeCollectionArray()
    {
        $arrangeCollection = array();
        foreach ($this->collections['smart_collections'] as $collection)
        {
            $collectionSubmission = array(
                'collection_id' => $collection['id'],
                'title' => $collection['title'],
                'description' => $collection['body_html']
            );
            array_push($arrangeCollection, $collectionSubmission);
        }
        return $arrangeCollection;
    }

    public function getProducts2CollectionsRels()
    {
        try {
            $this->products2collectionRels = json_decode($this->sendRequest("collects.json"), true);
        } catch (\Exception $exception)
        {
            return $exception->getMessage();
        }
        return $this;
    }

    public function arrangeProducts2CollectionsRelsArray()
    {
        $arrangeRels = array();
        foreach ($this->products2collectionRels['collects'] as $products2collectionRel)
        {
            $relsSubmission = array(
                'relation_id' => $products2collectionRel['id'],
                'collection_id' => $products2collectionRel['collection_id'],
                'product_id' => $products2collectionRel['product_id']
            );
            array_push($arrangeRels, $relsSubmission);
        }
        return $arrangeRels;
    }
}