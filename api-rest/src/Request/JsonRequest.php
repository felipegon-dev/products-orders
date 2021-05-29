<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class JsonRequest.
 */
class JsonRequest
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * JsonRequest constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * getData.
     *
     * @return array
     */
    public function getData()
    {
        $data = json_decode($this->request->getContent(), true);
        $data = is_array($data) ? $data : [];

        return $data;
    }

    /**
     * @param string $param
     *
     * @return mixed|null
     */
    public function getParam(string $param)
    {
        $data = $this->getData();

        return isset($data[$param]) ? $data[$param] : null;
    }
}
