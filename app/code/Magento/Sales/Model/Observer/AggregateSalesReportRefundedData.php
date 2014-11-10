<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Sales\Model\Observer;

use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class AggregateSalesReportRefundedData
 */
class AggregateSalesReportRefundedData
{
    /**
     * @var ResolverInterface
     */
    protected $localeResolver;

    /**
     * @var TimezoneInterface
     */
    protected $localeDate;

    /**
     * @var \Magento\Sales\Model\Resource\Report\RefundedFactory
     */
    protected $refundedFactory;

    /**
     * @param ResolverInterface $localeResolver
     * @param TimezoneInterface $timezone
     * @param \Magento\Sales\Model\Resource\Report\RefundedFactory $refundedFactory
     */
    public function __construct(
        ResolverInterface $localeResolver,
        TimezoneInterface $timezone,
        \Magento\Sales\Model\Resource\Report\RefundedFactory $refundedFactory
    ) {
        $this->localeResolver = $localeResolver;
        $this->localeDate = $timezone;
        $this->refundedFactory = $refundedFactory;
    }

    /**
     * Refresh sales refunded report statistics for last day
     *
     * @return void
     */
    public function execute()
    {
        $this->localeResolver->emulate(0);
        $currentDate = $this->localeDate->date();
        $date = $currentDate->subHour(25);
        $this->refundedFactory->create()->aggregate($date);
        $this->localeResolver->revert();
    }
}