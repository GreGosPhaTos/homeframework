<?php
namespace HomeFramework\http;

/**
 * XML Response Class
 */
class XMLResponse extends HTTPResponse
{
        
    /**
     * rootNodeName of our XML
     * @var string
     */
    private $_rootNodeName;

    /**
     * Constructor
     *
     * @param string $body       Body of the response
     * @param null   $rootNodeName
     * @param int    $statusCode Status code
     * @param array  $headers    Array of headers
     *
     * @internal param string $rootNode Root node of the XML
     * @return \HomeFramework\http\XMLResponse
     */
    public function __construct($body = null, $rootNodeName = null, $statusCode = 200, array $headers = array())
    {
        $this->setBody($body);
        $this->setRootNodeName($rootNodeName);  
        $this->setStatusCode($statusCode);
        $this->setHeaders($headers);
    }
    
    /**
     * Set the header and force the Content-type to be XML
     *
     * @param array $headers Array of headers
     * @return void
     */
    public function setHeaders(array $headers)
    {
        if ( empty($headers['Content-Type']) ) {
            $headers['Content-Type'] = 'text/xml; charset=utf-8';
        }
        parent::setHeaders($headers);
    }
    
    /**
     * Setter of the root node
     * 
     * @param string $rootNodeName
     */
    public function setRootNodeName($rootNodeName)
    {
        $this->_rootNodeName = $rootNodeName;
    }

    /**
     * Send the response body to the standard output
     *
     * @return void
     */
    public function sendBody()
    {
        $body = $this->getBody();
        if (is_array($body)) {
            echo $this->arrayToXml($body, $this->_rootNodeName);
        } else {
            echo $body;
        }
    }

    /**
     * Returns an XML string from an array
     *
     * @param array  $array             The input array.
     * @param string $rootNodeName      (Optional) The root node. Defaults to properties
     *
     * @throws \Exception
     * @return string the output string
     */
    private function arrayToXml(array $array, $rootNodeName)
    {
        if (empty($rootNodeName)) {
            throw new \Exception('rootNode is required.');   
        }
        
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
       
        $xmlWriter->startDocument('1.0', 'UTF-8');

        $xmlWriter->startElement($rootNodeName);
        $this->createElements($array, $xmlWriter);
        $xmlWriter->endElement();

        $xmlWriter->endDocument();
        
        $batchXmlString = $xmlWriter->outputMemory(true);

        return $batchXmlString;
    }

    /**
     * Generates XML Nodes from an array recursively
     *
     * @param  array  $array an array passed as a reference
     * @param  \XMLWriter $xmlWriter
     */
    private function createElements(&$array, \XMLWriter $xmlWriter)
    {
        foreach ($array as $key => $value) {
            if (preg_match('/\w\/\w/', $key) || preg_match('/\d/', $key)) {
                $xmlWriter->startElement('node');
                $xmlWriter->writeAttribute('key', $key);
            }
            else {
                $xmlWriter->startElement($key);
            }

            if (is_array($value)) {
                $this->createElements($value, $xmlWriter);
            }
            else {
                $xmlWriter->text($value);
            }

            $xmlWriter->endElement();
        }
    }
}


