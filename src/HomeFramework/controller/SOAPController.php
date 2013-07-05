<?php
namespace HomeFramework\controller;

class SOAPController extends BackController {

    /**
     * @var
     */
    protected $soapClient;

    /**
     * @param \SoapClient $soapClient
     */
    private function setSoapClient (\SoapClient $soapClient) {
        $this->soapClient = $soapClient;
    }

    /**
     * @param $wsdl
     * @param array $options
     */
    protected function buildSoapClient($wsdl, $options = array()) {
        $soapClient = new \SoapClient($wsdl);

        if (!count($options)) {
            $options = array(
                'trace' => 1,
                'exceptions' => 1
            );
        }
        $this->setSoapClient($soapClient, $options);
    }
}