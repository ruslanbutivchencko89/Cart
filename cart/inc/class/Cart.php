<?php
namespace Widget\App;

/**
 * Cart Class
 *
 * @version 1.0.0
 */
class Cart implements iCart
{   
    /**
     * @var array $products Products
     */
    protected $products = [];

    /**
     * @var string $products_sum Products Sum
     */
    protected $products_sum = 0;

    /**
     * @var string $discount Discount
     */
    protected $discount = 0;

    /**
     * @var string $shippipng_price Shippipng Price
     */
    protected $shippipng_price = 0;

    /**
     * @var string $name Name
     */
    private $total = 0;

    /**
     * Loop to add Product to $products
     */
    public function setProducts(array $array)
    {
        foreach ($array as $code) {
            static::setProduct($code);
        }

        return $this;
    }

    /**
     * Add Product to $products
     */
    public function setProduct(string $code)
    {
        $product = new Product($code);
        $this->products[] = $product;

        return $this;
    }

    /**
     * @return $total
     */
    public function getTotal() :float
    {
        self::recalculateCart();
        
        return round($this->total, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * @return Products Sum
     */
    protected function getProductsSum() :float
    {   
        $products_sum = 0;
        foreach ($this->products as $product) {
            $products_sum += $product->getPrice();
        }

       return $products_sum;
    }

    /**
     * @return Discount
     */
    protected function getDiscount() :float
    {
        $discount = 0;
        $code_array = [];
        foreach ($this->products as $product) {
            $code = $product->getCode();
            $price = $product->getPrice();

            if ( $code == 'R01' && in_array('R01', $code_array) ) {
                $key = array_search('R01', $code_array);
                unset($code_array[$key]);
                $discount += ($price/2);
            } else {
                $code_array[] = $code;
            }
        }

        return $discount;
    }

    /**
     * @return Shippipng Price
     */
    protected function getShippipngPrice() :float
    {
        $shippipng_price = 0;
        if ($this->products_sum - $this->discount < 50) {
            $shippipng_price = 4.95;
        } else if ($this->products_sum - $this->discount < 90) {
            $shippipng_price = 2.95;
        }

        return $shippipng_price;
    }

    /**
     * Set $discount, $products_sum, $shippipng_price, $total
     */
    private function recalculateCart()
    {
        $this->discount = static::getDiscount();
        $this->products_sum = static::getProductsSum();
        $this->shippipng_price = static::getShippipngPrice();
        $this->total = $this->products_sum - $this->discount + $this->shippipng_price;

        return $this;
    }
}
