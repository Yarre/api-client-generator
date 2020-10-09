<?php declare(strict_types=1);

/*
 * This file was generated by docler-labs/api-client-generator.
 *
 * Do not edit it manually.
 */

namespace Test\Request\Mapper;

use GuzzleHttp\Cookie\CookieJar;
use Nyholm\Psr7\Request;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;
use Test\Request\RequestInterface;
use Test\Serializer\BodySerializer;

class NyholmRequestMapper implements RequestMapperInterface
{
    /** @var BodySerializer */
    private $bodySerializer;

    /**
     * @param BodySerializer $bodySerializer
     */
    public function __construct(BodySerializer $bodySerializer)
    {
        $this->bodySerializer = $bodySerializer;
    }

    /**
     * @param RequestInterface $request
     *
     * @return PsrRequestInterface
     */
    public function map(RequestInterface $request): PsrRequestInterface
    {
        $body        = $this->bodySerializer->serializeRequest($request);
        $query       = \http_build_query($request->getQueryParameters(), '', '&', PHP_QUERY_RFC3986);
        $psr7Request = new Request($request->getMethod(), $request->getRoute(), $request->getHeaders(), $body, '1.1');
        $psr7Request = $psr7Request->withUri($psr7Request->getUri()->withQuery($query));
        $cookieJar   = new CookieJar(true, $request->getCookies());
        $psr7Request = $cookieJar->withCookieHeader($psr7Request);

        return $psr7Request;
    }
}