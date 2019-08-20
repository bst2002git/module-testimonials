<?php
namespace Swissup\Testimonials\Block\Widgets;

use Swissup\Testimonials\Model\Data as TestimonialsModel;

class Slider extends \Magento\Framework\View\Element\Template
     implements \Magento\Widget\Block\BlockInterface
{
    const DEFAULT_TEMPLATE = 'widgets/slider.phtml';

    /**
     * @var \Swissup\Testimonials\Model\ResourceModel\Data\CollectionFactory
     */
    private $testimonialsCollectionFactory;

    /**
     * Get testimonials list helper
     * @var \Swissup\Testimonials\Helper\ListHelper
     */
    private $listHelper;

		/**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Swissup\Testimonials\Model\ResourceModel\Data\CollectionFactory $testimonialsCollectionFactory
     * @param \Swissup\Testimonials\Helper\ListHelper $listHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Swissup\Testimonials\Model\ResourceModel\Data\CollectionFactory $testimonialsCollectionFactory,
        \Swissup\Testimonials\Helper\ListHelper $listHelper,
				\Magento\Cms\Model\Template\FilterProvider $filterProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->testimonialsCollectionFactory = $testimonialsCollectionFactory;
        $this->listHelper = $listHelper;
				$this->_filterProvider = $filterProvider;
    }

    public function _construct()
    {
        if (!$this->hasData('template')) {
            $this->setData('template', self::DEFAULT_TEMPLATE);
        }

        return parent::_construct();
    }

    /**
     * @return \Swissup\Testimonials\Model\ResourceModel\Data\Collection
     */
    public function getTestimonials()
    {
        if (!$this->hasData('testimonials')) {
            $storeId = $this->_storeManager->getStore()->getId();
            $testimonials = $this->testimonialsCollectionFactory
                ->create()
                ->addStatusFilter(TestimonialsModel::STATUS_ENABLED)
                ->addWidgetFilter(1)
                ->addStoreFilter($storeId);

            $testimonials->getSelect()
                    ->order(new \Zend_Db_Expr('RAND()'))
                    ->limit($this->getItemsNumber());

            $this->setData('testimonials', $testimonials);
        }

        return $this->getData('testimonials');
    }

    /**
     * Get user profile image url
     * @param \Swissup\Testimonials\Model\Data $testimonial
     * @return String
     */
    public function getProfileImageUrl($testimonial)
    {
        $image = $this->listHelper->resize($testimonial);

        return $image ? $image : $this->getViewFileUrl('Swissup_Testimonials::images/empty.svg');
    }

		/**
     * Prepare HTML content
     *
     * @return string
     */
    public function getCmsFilterContent($value='')
    {
        $html = $this->_filterProvider->getPageFilter()->filter($value);
        return $html;
    }
}
