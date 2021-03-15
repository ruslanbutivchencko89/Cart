<?php
require_once 'cart/index.php';

use Widget\App\Product;
use Widget\App\Cart;


class New_Product extends Product
{
	function __construct($code) {
    	$this->code = $code;
    	$this->name = 'TEst';
    	$this->price = 100;
    }
}

class New_Cart extends Cart
{

	public function setProduct(string $code)
    {
        $product = new New_Product($code);
        $this->products[] = $product;
    }

    protected function getShippipngPrice() :float
    {
        $shippipng_price = 0;
        if ($this->products_sum - $this->discount < 250) {
            $shippipng_price = 4.95;
        } else if ($this->products_sum - $this->discount < 390) {
            $shippipng_price = 2.95;
        }

        return $shippipng_price;
    }

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
}

//parent
echo '<p>Test parent cart</p>';
$cart = new Cart();
$cart->setProducts(['B01', 'G01']);
echo 'Products: B01, G01 - Total: ' . $cart->getTotal();
echo '<br>';

$cart2 = new Cart();
$cart2->setProducts(['R01', 'R01']);
echo 'Products: B01, G01 - Total: ' . $cart2->getTotal();
echo '<br>';

$cart3 = new Cart();
$cart3->setProducts(['R01', 'G01']);
echo 'Products: R01, G01 - Total: ' . $cart3->getTotal();
echo '<br>';

$cart4 = new Cart();
$cart4->setProducts(['B01', 'B01', 'R01', 'R01', 'R01']);
echo 'Products: B01, B01, R01, R01, R01 - Total: ' . $cart4->getTotal();
echo '<br>';
echo '<hr>';

//child
echo '<p>Test child cart</p>';
$cart = new New_Cart();
$cart->setProducts(['B01', 'G01']);
echo $cart->getTotal();
echo '<br>';

$cart2 = new New_Cart();
$cart2->setProducts(['R01', 'R01']);
echo $cart2->getTotal();
echo '<br>';

$cart3 = new New_Cart();
$cart3->setProducts(['R01', 'G01']);
echo $cart3->getTotal();
echo '<br>';

$cart4 = new New_Cart();
$cart4->setProducts(['B01', 'B01', 'R01', 'R01', 'R01']);
echo $cart4->getTotal();
echo '<br>';
