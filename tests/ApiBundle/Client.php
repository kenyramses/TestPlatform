<?php

namespace ApiBundle\Client;

use Symfony\Bundle\FrameworkBundle\Client as BaseClient;
use Symfony\Component\HttpFoundation\Request;

class Client extends BaseClient
{
    /**
     * {@inheritdoc}
     */
    public function get($uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $this->request(Request::METHOD_GET, $uri, $parameters, $files, $server, $content, $changeHistory);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $this->request(Request::METHOD_POST, $uri, $parameters, $files, $server, $content, $changeHistory);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $this->request(Request::METHOD_PUT, $uri, $parameters, $files, $server, $content, $changeHistory);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $this->request(Request::METHOD_DELETE, $uri, $parameters, $files, $server, $content, $changeHistory);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $this->request(Request::METHOD_PATCH, $uri, $parameters, $files, $server, $content, $changeHistory);
    }

    /**
     * @return array
     */
    public function getJsonResponse ()
    {
        $content = $this->getResponse()->getContent();

        return json_decode($content, true);
    }
}