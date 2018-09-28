<?php
/**
 * Orange Cat
 * Copyright (C) 2018 Orange Cat
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html
 *
 * @category Orangecat
 * @package Orangecat_OneProductRedirect
 * @copyright Copyright (c) 2018 Orange Cat
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author Oliverio Gombert <olivertar@gmail.com>
 */

namespace Orangecat\OneProductRedirect\Block\Catalog\Product;

class ListProduct
{
    protected $response;
    
    protected $scopeConfig;

    public function __construct(
       \Magento\Framework\App\Response\Http $response,
       \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->response = $response;
        $this->scopeConfig = $scopeConfig;
    }

    public function afterGetLoadedProductCollection(\Magento\Catalog\Block\Product\ListProduct $subject, $resultCollection)
    {
        if ($resultCollection->count() == 1 && $this->getConfig('oneproductredirect/general/enabled') == 1) {
            $product = $resultCollection->getFirstItem();
            $this->response->setRedirect($product->getProductUrl());
        }

        return $resultCollection;
    }
    
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
    }
}