<?php
namespace HomeFramework\http;

class JSONResponse extends HTTPResponse
{
    /**
     * Set the header and force the Content-type to be Json
     *
     * @param array $headers Array of headers
     * @return void
     */
    public function setHeaders(array $headers)
    {
        $headers['Content-Type'] = 'application/json';
        parent::setHeaders($headers);
    }

    /**
     * Send the response body, encoded in a JSON format, to the standard output
     *
     * If the body is not an array, we wrap it into an array so the response will be a valid JSON object
     *
     * @return void
     */
    public function sendBody()
    {
        $body = $this->getBody();

        if (!is_array($body) && !is_object($body)) {
            $body = array($body);
        }
        echo json_encode($body);
    }
}

