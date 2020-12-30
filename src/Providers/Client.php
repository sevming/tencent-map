<?php

namespace Sevming\TencentMap\Providers;

use \Closure;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\{RequestInterface, ResponseInterface};
use Sevming\Foundation\Exceptions\{Exception AS FoundationException, InvalidConfigException, HttpException};
use Sevming\Foundation\Supports\Response;
use Sevming\TencentMap\TencentMap;

class Client
{
    /**
     * @var TencentMap
     */
    protected $app;

    /**
     * Constructor.
     *
     * @param TencentMap $app
     */
    public function __construct(TencentMap $app)
    {
        $this->app = $app;
        $this->registerMiddlewares();
    }

    /**
     * GET request.
     *
     * @param string $url
     * @param array  $query
     *
     * @return mixed
     * @throws GuzzleException|FoundationException
     */
    public function get(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * Request.
     *
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @return mixed
     * @throws GuzzleException|FoundationException
     */
    public function request(string $url, string $method = 'GET', array $options = [])
    {
        $response = $this->app->http->request($url, $method, $options, true);
        if (!$this->isSuccess($response)) {
            throw new HttpException(\json_encode([
                'url' => $url,
                'method' => $method,
                'options' => $options,
                'contents' => Response::resolveData($response, 'array'),
            ]), $response->getStatusCode(), $response);
        }

        return Response::detectAndConvertData($response, $this->app->config['response_type']);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     * @throws InvalidConfigException
     */
    protected function isSuccess(ResponseInterface $response)
    {
        $result = Response::resolveData($response);
        if (!$result->has('status') || 0 !== $result->get('status')) {
            return false;
        }

        return true;
    }

    /**
     * Register http middlewares.
     */
    protected function registerMiddlewares()
    {
        $this->app->http->pushMiddleware($this->keyMiddleware(), 'key');
    }

    /**
     * Key middleware.
     *
     * @return Closure
     */
    protected function keyMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                parse_str($request->getUri()->getQuery(), $query);
                $query = http_build_query(array_merge([
                    'key' => $this->app->config['key'],
                ], $query));
                $request = $request->withUri($request->getUri()->withQuery($query));

                return $handler($request, $options);
            };
        };
    }
}