<?php

namespace Svea\WebPay\Test\UnitTest\AdminService;

use Svea\WebPay\WebPayItem;
use Svea\WebPay\WebPayAdmin;
use Svea\WebPay\Config\SveaConfig;
use Svea\WebPay\Constant\DistributionType;


/**
 * @author Kristian Grossman-Madsen for Svea Webpay
 */
class CreditOrderRowsRequestTest extends \PHPUnit_Framework_TestCase
{

    /// characterising test for INTG-462
    // invoice
    public function test_creditOrderRows_creditInvoiceOrderRows_does_not_validate_setOrderId()
    {
        $creditOrderRowsBuilder = WebPayAdmin::creditOrderRows(SveaConfig::getDefaultConfig())
            ->setInvoiceId(987654)
            ->setInvoiceDistributionType(DistributionType::POST)
            ->setCountryCode('SE')
            ->setRowToCredit(1);

        // shouldn't raise any exception

        $request = $creditOrderRowsBuilder->creditInvoiceOrderRows()->prepareRequest();
    }

    // card
    public function test_creditOrderRows_creditCardOrderRows_validates_setOrderId()
    {
        $creditOrderRowsBuilder = WebPayAdmin::creditOrderRows(SveaConfig::getDefaultConfig())
            //->setOrderId(987654)    // i.e. setTransactionId()
            ->setInvoiceDistributionType(DistributionType::POST)
            ->setCountryCode('SE')
            ->setRowToCredit(1);

        $this->setExpectedException(
            'Svea\WebPay\BuildOrder\Validator\ValidationException', 'orderId is required for creditCardOrderRows(). Use method setOrderId().'
        );

        $request = $creditOrderRowsBuilder->creditCardOrderRows()->prepareRequest();
    }

    // direct bank
    public function test_creditOrderRows_creditDirectBankOrderRows_validates_setOrderId()
    {
        $creditOrderRowsBuilder = WebPayAdmin::creditOrderRows(SveaConfig::getDefaultConfig())
            //->setTransactionId(987654)    // alias for setOrderId()
            ->setInvoiceDistributionType(DistributionType::POST)
            ->setCountryCode('SE')
            ->setRowToCredit(1);

        $this->setExpectedException(
            'Svea\WebPay\BuildOrder\Validator\ValidationException', 'orderId is required for creditCardOrderRows(). Use method setOrderId().'
        );

        $request = $creditOrderRowsBuilder->creditDirectBankOrderRows()->prepareRequest();
    }

    public function test_creditOrderRows_creditPaymentPlanOrderRows_credit_row_using_row_index()
    {
        $config = SveaConfig::getDefaultConfig();

        $request = WebPayAdmin::creditOrderRows($config)
            ->setContractNumber('123123')
            ->setCountryCode('SE')
            ->setRowToCredit(1)
            ->creditPaymentPlanOrderRows()->prepareRequest();
        $this->assertEquals(1, $request->CancellationRows->enc_value[0]->enc_value->RowNumber->enc_value);
        $this->assertEquals('123123', $request->ContractNumber->enc_value);
    }

    public function test_creditOrderRows_creditPyamentplanOrderRows()
    {
        $config = SveaConfig::getDefaultConfig();

        $orderRows[] = WebPayItem::orderRow()
            ->setAmountIncVat(123.9876)
            ->setVatPercent(25)
            ->setQuantity(1)
            ->setDescription("row 1");
        $orderRows[] = WebPayItem::orderRow()
            ->setAmountIncVat(10.00)
            ->setVatPercent(25)
            ->setQuantity(1)
            ->setDescription("row 2");
        $request = WebPayAdmin::creditOrderRows($config)
            ->setContractNumber('123132')
            ->setCountryCode('SE')
            ->addCreditOrderRows($orderRows)
            ->creditPaymentplanOrderRows()->prepareRequest();

        $this->assertEquals(123.9876, $request->CancellationRows->enc_value[0]->enc_value->AmountInclVat->enc_value);
        $this->assertEquals('123132', $request->ContractNumber->enc_value);


    }

    public function test_creditOrderRows_creditCardOrderRowsAsIncvatAndVatPercent()
    {
        $config = SveaConfig::getDefaultConfig();

        $orderRows[] = WebPayItem::orderRow()
            ->setAmountIncVat(123.9876)
            ->setVatPercent(25)
            ->setQuantity(1)
            ->setDescription("row 1");

        $request = WebPayAdmin::creditOrderRows($config)
            ->setTransactionId()
            ->setCountryCode('SE')
            ->addCreditOrderRows($orderRows)
            ->creditCardOrderRows()
            ->prepareRequest();


    }

    public function test_creditOrderRows_creditCardOrderRowsAsAmountExVatAndVatPercent()
    {
        $config = SveaConfig::getDefaultConfig();

        $orderRows[] = WebPayItem::orderRow()
            ->setAmountIncVat(123.9876)
            ->setVatPercent(25)
            ->setQuantity(1)
            ->setDescription("row 1");

        $request = WebPayAdmin::creditOrderRows($config)
            ->setTransactionId()
            ->setCountryCode('SE')
            ->addCreditOrderRows($orderRows)
            ->creditCardOrderRows()
            ->prepareRequest();



    }

    public function test_creditOrderRows_creditCardOrderRowsAsAmountExVatAndAmountIncVat()
    {
        $config = SveaConfig::getDefaultConfig();

        $orderRows[] = WebPayItem::orderRow()
            ->setAmountIncVat(123.9876)
            ->setAmountExVat(140)
            ->setQuantity(1)
            ->setDescription("row 1");

        $request = WebPayAdmin::creditOrderRows($config)
            ->setTransactionId()
            ->setCountryCode('SE')
            ->addCreditOrderRows($orderRows)
            ->creditCardOrderRows()
            ->prepareRequest();



    }

    /**
     * @expectedException \Svea\WebPay\BuildOrder\Validator\ValidationException
     * @expectedExceptionMessage -missing value : Description is required.
     */
    public function test_creditOrderRows_creditPyamentplanOrderRows_noDesciription()
    {

        $config = SveaConfig::getDefaultConfig();

        $orderRows[] = WebPayItem::orderRow()
            ->setAmountIncVat(10.00)
            ->setVatPercent(25)
            ->setQuantity(1);
        $orderRows[] = WebPayItem::orderRow()
            ->setAmountIncVat(10.00)
            ->setVatPercent(25)
            ->setQuantity(1);
        $credit = WebPayAdmin::creditOrderRows($config)
            ->setContractNumber(123123)
            ->setCountryCode('SE')
            ->addCreditOrderRows($orderRows)
            ->creditPaymentplanOrderRows()->prepareRequest();

    }


}
