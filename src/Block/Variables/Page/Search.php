<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Smile Searchandising Suite to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile_ElasticSuiteTracker
 * @author    Romain Ruaud <romain.ruaud@smile.fr>
 * @copyright 2016 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Smile\ElasticSuiteTracker\Block\Variables\Page;
use Magento\Framework\View\Element\Template;

/**
 * Search variables block for page tracking, exposes all search related tracking variables
 *
 * @category Smile
 * @package  Smile_ElasticSuiteTracker
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class Search extends \Smile\ElasticSuiteTracker\Block\Variables\Page\AbstractBlock
{
    /**
     * Catalog layer
     *
     * @var \Magento\Catalog\Model\Layer
     */
    private $catalogLayer;

    /**
     * Catalog search data
     *
     * @var \Magento\CatalogSearch\Helper\Data
     */
    private $catalogSearchData;

    /**
     * Set the default template for page variable blocks
     *
     * @param Template\Context                       $context           The template context
     * @param \Magento\Framework\Json\Helper\Data    $jsonHelper        The Magento's JSON Helper
     * @param \Smile\ElasticSuiteTracker\Helper\Data $trackerHelper     The Smile Tracker helper
     * @param \Magento\Framework\Registry            $registry          Magento Core Registry
     * @param \Magento\Catalog\Model\Layer\Resolver  $layerResolver     The Magento layer resolver
     * @param \Magento\CatalogSearch\Helper\Data     $catalogSearchData The Catalogsearch data
     * @param array                                  $data              The block data
     *
     * @return Search
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Smile\ElasticSuiteTracker\Helper\Data $trackerHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\CatalogSearch\Helper\Data $catalogSearchData,
        array $data = []
    ) {
        $this->catalogLayer      = $layerResolver->get();
        $this->catalogSearchData = $catalogSearchData;
        parent::__construct($context, $jsonHelper, $trackerHelper, $registry, $data);
    }

    /**
     * Append the user fulltext query to the tracked variables list
     *
     * @return array
     */
    public function getVariables()
    {
        $variables = ['search.query' => $this->catalogSearchData->getEscapedQueryText()];

        // @TODO The isSpellchecked() method does not exists on native M2
        /*if ($layer = $this->catalogLayer) {
            $productCollection = $layer->getProductCollection();
            $variables['search.is_spellchecked'] = $productCollection->isSpellchecked();
        }*/

        return $variables;
    }
}
