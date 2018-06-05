<?php
use Model\Model as Model;
use drivers\mysql as MysqlDriver;
use libraries\MysqlQueryLib as Query;
use config\Configurator as Configurator;
use libraries\ShopifyApiLib as Shopify;

class MainControllerModel extends Model
{
    private $shopify;

    public function initShopify()
    {
        $this->shopify = new Shopify\ShopifyApiLib();
        try {
            $this->shopify->config(array(
                "apiKey" => "636d7064a3b72c4f17c22ad059778d9a",
                "apiPassword" => "25d0ec19e305e31ed71c43a987f96d0f",
                "publicShopUrl" => "strangedevstore.myshopify.com"
            ));
            $this->shopify->getStorefrontAccessToken();
        } catch (Exception $exception) {
            $exception->getMessage();
        }

        $this->shopify->createShopUrl();
    }

    public function addProducts2Database()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        $products = $this->shopify->getProducts()->arrangeProductsArray();
        foreach ($products as $product)
        {
            if($query->table('products')->where("product_id = {$product['product_id']}")->countResults() === 0)
            {
                $query->table('products')->insert($product);
            }
        }
    }

    public function addCollection2Database()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        $collections = $this->shopify->getCollections()->arrangeCollectionArray();
        foreach ($collections as $collection)
        {
            if($query->table('collections')->where("collection_id = {$collection['collection_id']}")->countResults() === 0)
            {
                $query->table('collections')->insert($collection);
            }
        }
    }

    public function addRelation2Database()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        $relations = $this->shopify->getProducts2CollectionsRels()->arrangeProducts2CollectionsRelsArray();
        foreach ($relations as $relation)
        {
            if($query->table('relation')->where("relation_id = {$relation['relation_id']}")->countResults() === 0)
            {
                $query->table('relation')->insert($relation);
            }
        }
    }

    public function getCollections()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        return $query->table('collections')->get()->toArray();
    }

    public function getProducts()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        return $query->table('products')->order('created_at', 'DESC')->get()->toArray();
    }

    public function getProductsFromCollection()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        return $query->table('products')->where("product_id IN (SELECT product_id FROM relation WHERE collection_id = {$this->getVarFromPost('collection')})")->get()->toArray();
    }
}