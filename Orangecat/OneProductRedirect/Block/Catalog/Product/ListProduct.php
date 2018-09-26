<?php
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