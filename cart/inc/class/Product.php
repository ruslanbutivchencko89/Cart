<?php
namespace Widget\App;

/**
 * Product Class
 *
 * @version 1.0.0
 */
class Product
{
    /**
     * @var string $name Name
     */
    protected $name;

    /**
     * @var string $code Code
     */
    protected $code;

    /**
     * @var float $price Price
     */
    protected $price; 

    /**
     * Set $code, $name, $price
     */
    public function __construct($code) {
    	$this->code = $code;
    	$csv = array_map('str_getcsv', file('cart/data/pruducts.csv'));

  		$result = [];
  		for($i = 1; $i < count($csv); $i++){
  			for($j = 0; $j <= count($csv[0])-1; $j++){
  				$result[$i][$csv[0][$j]] = $csv[$i][$j];
  			}
  		}
  		foreach ($result as $key => $value) {
  			if($value['Code'] == $code){
  				$this->name = $value['Product'];
  				$this->price = floatval(str_replace('$', '', $value['Price']));
  			}
  		}
   	}

    /**
     * @return $price
     */
   	public function getPrice(){
   		return $this->price;
   	}

    /**
     * @return $code
     */
   	public function getCode(){
   		return $this->code;
   	}
}
