<?php

namespace Svea\WebPay\Config;

/**
 * This is Svea Test credentials, and you can use this parameters during developing and testing
 * For production parameters you have to change config_prod.php file
 */
return array(
    'integrationParams' => array(
        'integrationcompany' => "myIntegrationCompany",
        'integrationversion' => "myIntegrationVersion",
        'integrationplatform' => "myIntegrationPlatform"
    ),
    'commonCredentials' => array(
        'merchantId' => '1130',
        'secret' => '8a9cece566e808da63c6f07ff415ff9e127909d000d259aba24daa2fed6d9e3f8b0b62e8ad1fa91c7d7cd6fc3352deaae66cdb533123edf127ad7d1f4c77e7a3'
    ),
    'defaultCountryCode' => 'SE',
    'credentials' => array(
        'SE' => array(
            ConfigurationProvider::INVOICE_TYPE => array(
                'username' => 'sverigetest',
                'password' => 'sverigetest',
                'clientNumber' => 79021
            ),
            ConfigurationProvider::PAYMENTPLAN_TYPE => array(
                'username' => 'sverigetest',
                'password' => 'sverigetest',
                'clientNumber' => 59999
            )
        ),
        'NO' => array(
            ConfigurationProvider::INVOICE_TYPE => array(
                'username' => 'norgetest2',
                'password' => 'norgetest2',
                'clientNumber' => 33308
            ),
            ConfigurationProvider::PAYMENTPLAN_TYPE => array(
                'username' => 'norgetest2',
                'password' => 'norgetest2',
                'clientNumber' => 32503
            )
        ),
        'FI' => array(
            ConfigurationProvider::INVOICE_TYPE => array(
                'username' => 'finlandtest2',
                'password' => 'finlandtest2',
                'clientNumber' => 26136
            ),
            ConfigurationProvider::PAYMENTPLAN_TYPE => array(
                'username' => 'finlandtest2',
                'password' => 'finlandtest2',
                'clientNumber' => 27136
            )
        ),
        'DK' => array(
            ConfigurationProvider::INVOICE_TYPE => array(
                'username' => 'danmarktest2',
                'password' => 'danmarktest2',
                'clientNumber' => 62008
            ),
            ConfigurationProvider::PAYMENTPLAN_TYPE => array(
                'username' => 'danmarktest2',
                'password' => 'danmarktest2',
                'clientNumber' => 64008
            )
        ),
        'NL' => array(
            ConfigurationProvider::INVOICE_TYPE => array(
                'username' => 'hollandtest',
                'password' => 'hollandtest',
                'clientNumber' => 85997
            ),
            ConfigurationProvider::PAYMENTPLAN_TYPE => array(
                'username' => 'hollandtest',
                'password' => 'hollandtest',
                'clientNumber' => 86997
            )
        ),
        'DE' => array(
            ConfigurationProvider::INVOICE_TYPE => array(
                'username' => 'germanytest',
                'password' => 'germanytest',
                'clientNumber' => 14997
            ),
            ConfigurationProvider::PAYMENTPLAN_TYPE => array(
                'username' => 'germanytest',
                'password' => 'germanytest',
                'clientNumber' => 16997
            )
        )
    )
);