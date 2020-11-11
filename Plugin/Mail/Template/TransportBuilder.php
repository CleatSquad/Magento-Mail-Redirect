<?php
/**
 * Mim_MailRedirect extension.
 *
 * @author Mohamed El Mrabet
 * @copyright Copyright (c) (http://www.mohamedelmrabet.com/)
 */

namespace Mim\MailRedirect\Plugin\Mail\Template;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class TransportBuilder
 * @package Mim\MailRedirect\Plugin\Mail\Template
 */
class TransportBuilder
{
    /**
     * XML path for enable mail redirection
     */
    const XML_PATH_MAIL_REDIRECT_ENABLE = 'dev/mailredirect/enabled';

    /**
     * XML path for email used in mail redirection
     */
    const XML_PATH_MAIL_REDIRECT_EMAIL_TO = 'dev/mailredirect/email_to';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * TransportBuilder constructor.
     *
     * @param ScopeConfigInterface $scope
     */
    public function __construct(ScopeConfigInterface $scope)
    {
        $this->scopeConfig = $scope;
    }

    /**
     * Check whether if redirection mail is enabled
     *
     * @return bool
     */
    public function isRedirectionMailEnable()
    {
        return (bool)$this->scopeConfig->isSetFlag(
            self::XML_PATH_MAIL_REDIRECT_ENABLE,
            ScopeInterface::SCOPE_WEBSITES
        );
    }

    /**
     * Redirect to email
     *
     * @param \Magento\Framework\Mail\Template\TransportBuilder $subject
     * @param array|string $address
     * @param string $name
     * @return array
     */
    public function beforeAddTo(\Magento\Framework\Mail\Template\TransportBuilder $subject, $address, $name = '') : array
    {
        if ($this->isRedirectionMailEnable() && ($address != "" || (is_array($address) && count($address) > 0))) {
            if (!is_array($address)) {
                $address = [$address];
            }
            $emails = $this->getToEmail();
            $emailsValues = $emails;
            array_walk($emails, function (&$value, $key) use ($address) {
                $value = sprintf('Redirected from (%d) <%s>', $key, implode(',', $address));
            });
            $emails = array_combine($emails, $emailsValues);
            return [$emails, sprintf('Redirected from <%s>', implode(',', $address))];
        }

        return [$address, $name];
    }

    /**
     * Redirect Cc email
     *
     * @param \Magento\Framework\Mail\Template\TransportBuilder $subject
     * @param array|string $address
     * @param string $name
     * @return array
     */
    public function beforeAddCc(\Magento\Framework\Mail\Template\TransportBuilder $subject, $address, $name = '') : array
    {
        if ($this->isRedirectionMailEnable() && ($address != "" || (is_array($address) && count($address) > 0))) {
            if (!is_array($address)) {
                $address = [$address];
            }
            return [$this->getToEmail(), sprintf('Redirected from %1', implode(',', $address))];
        }

        return [$address, $name];
    }

    /**
     * Redirect Bcc email
     *
     * @param \Magento\Framework\Mail\Template\TransportBuilder $subject
     * @param array|string $address
     * @return string
     */
    public function beforeAddBcc(\Magento\Framework\Mail\Template\TransportBuilder $subject, $address) : string
    {
        if ($this->isRedirectionMailEnable() && ($address != "" || (is_array($address) && count($address) > 0))) {
            return $this->getToEmail()[0];
        }

        return $address;
    }

    /**
     * Retrieve to email of redirection
     *
     * @return array []
     */
    protected function getToEmail()
    {
        return explode(",", $this->scopeConfig->getValue(self::XML_PATH_MAIL_REDIRECT_EMAIL_TO));
    }
}
