<?php
namespace UnitTests\DependsMockTest;

/**
 * Class Products
 * @package UnitTests\DependsMockTest
 *
 * <code>
 *   $productFactory = new ProductFactory();
 *   $products = new Products($productFactory);
 *   $products->addProducts(array());
 * </code>
 */

class Products
{
    private $productFactory;

    /**
     * @var Product[]
     */
    private $products = array();

    public function __construct(ProductFactory $productFactory)
    {
        $this->productFactory = $productFactory;
    }

    public function addProduct(array $product)
    {
        $this->products[$product['id']] = $this->productFactory->build($product);
    }

    public function addProducts(array $products)
    {
        if (count($products) == 0) {
            throw new \InvalidArgumentException('Products array is empty.');
        }

        foreach ($products as $product) {
            $this->addProduct($product);
        }
    }

    public function getProduct($id)
    {
        $id = (int)$id;
        if ($id <= 0) {
            throw new \InvalidArgumentException('Invalid product code.');
        }
        return isset($this->products[$id]) ? $this->products[$id] : null;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function resetPrices()
    {
        foreach($this->products as $product) {
            $product->setPrice(0);
        }
    }
}