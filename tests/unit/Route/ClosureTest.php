<?php
// 闭包路由测试
namespace Webman\Test\Route;

use FastRoute\Dispatcher;
use Mockery;
use PHPUnit\Framework\TestCase;
use Webman\Http\Request;
use Webman\Route;

class ClosureTest extends TestCase
{
    /**
     * 加载闭包路由配置
     */
    public static function setUpBeforeClass(): void
    {
        Route::load(__DIR__ . '/ClosureRouteConfig.php');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @param $path
     * @param string $method
     * @param string $host
     * @return Mockery\Mock|Request
     */
    protected function makeRequest($path, $method = 'GET', $host = 'localhost')
    {
        $request = Mockery::mock(Request::class)->makePartial();
        $request->shouldReceive('host')->andReturn($host);
        $request->shouldReceive('pathinfo')->andReturn($path);
        $request->shouldReceive('url')->andReturn('/' . $path);
        $request->shouldReceive('method')->andReturn(strtoupper($method));
        return $request;
    }

    /**
     * @param Request $request
     * @param $response
     * @return array
     */
    protected function getResponse(Request $request, $response): array
    {
        if ($response[0] === Dispatcher::FOUND) {
            return ['code' => 200, 'content' => $response[1]['callback']($request)];
        }

        return ['code' => 404, 'content' => ''];
    }

    public function testSimpleRequest()
    {
        $request = $this->makeRequest('foo', 'get');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('get-foo', $response['content']);

        $request = $this->makeRequest('foo', 'post');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('post-foo', $response['content']);

        $request = $this->makeRequest('foo', 'put');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('put-foo', $response['content']);

        $request = $this->makeRequest('foo', 'patch');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('patch-foo', $response['content']);

        $request = $this->makeRequest('foo', 'delete');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('delete-foo', $response['content']);

        $request = $this->makeRequest('foo', 'head');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('head-foo', $response['content']);

        $request = $this->makeRequest('foo', 'options');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('options-foo', $response['content']);
    }

    public function testAnyRequest()
    {
        $request = $this->makeRequest('any-foo', 'get');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('get-any', $response['content']);

        $request = $this->makeRequest('any-foo', 'post');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('post-any', $response['content']);

        $request = $this->makeRequest('any-foo', 'put');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('put-any', $response['content']);

        $request = $this->makeRequest('any-foo', 'patch');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('patch-any', $response['content']);

        $request = $this->makeRequest('any-foo', 'delete');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('delete-any', $response['content']);

        $request = $this->makeRequest('any-foo', 'head');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('head-any', $response['content']);

        $request = $this->makeRequest('any-foo', 'options');
        $response = $this->getResponse($request, Route::dispatch($request->method(), $request->url()));
        $this->assertEquals(200, $response['code']);
        $this->assertEquals('options-any', $response['content']);
    }
}