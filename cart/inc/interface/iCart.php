<?php
namespace Widget\App;

/**
 * iCart Interface
 *
 * @version 1.0.0
 */
interface iCart
{
	/**
     * Loop to add Product to cart
     */
	public function setProducts(array $array);

	/**
     * Add Product to cart
     */
    public function setProduct(string $code);

    /**
     * return cart Total
     */
    public function getTotal();
}
