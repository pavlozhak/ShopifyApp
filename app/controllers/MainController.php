<?php
use Controller\Controller as Controller;
use libraries\ShopifyApiLib as Shopify;

class MainController extends Controller
{
	public function index()
	{
        $this->view->render('index_view');
	}

	public function getCollections()
    {
        $model = new MainControllerModel();
        $collections = $model->getCollections();
        if(sizeof($collections) > 0) {
            $this->setContentType('application/json')->jsonEncode($collections);
        }
        else {
            echo false;
        }
    }

	public function synchronization()
    {
        $model = new MainControllerModel();
        $model->initShopify();
        $model->addProducts2Database();
        $model->addCollection2Database();
        $model->addRelation2Database();
        header("Location: https://shopify.dev-gear.pp.ua/main/index");
    }

    public function getProducts()
    {
        $model = new MainControllerModel();
        $products = $model->getProducts();
        if(sizeof($products) > 0) {
            $this->setContentType('application/json')->jsonEncode($products);
        }
        else {
            echo false;
        }
    }

    public function getCollectionsProducts()
    {
        $model = new MainControllerModel();
        $products = $model->getProductsFromCollection();
        if(sizeof($products) > 0) {
            $this->setContentType('application/json')->jsonEncode($products);
        }
        else {
            echo false;
        }
    }
}