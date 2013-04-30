<?php
namespace HomeFramework\http;

class RedirectResponse extends HTTPResponse
{
    /**
     * Force the status code to be 301
     * 
     * @param int $code Status code
     * @param string $text Http Status Text     Optional, defaults to null.
     * @return void
     */
    public function setStatusCode($code, $text = null)
    {
        parent::setStatusCode(301);
    }

    /**
     * Send the response body to the standard output
     *
     * @return void
     */
    public function sendBody()
    {
        echo 'Redirect...';
    }

    /**
     * Send the response header and add the Location one 
     * 
     * @return void
     */
    public function sendHeader()
    {
        $this->headers['Location'] = $this->getBody();
        parent::sendHeader();
    }
}

