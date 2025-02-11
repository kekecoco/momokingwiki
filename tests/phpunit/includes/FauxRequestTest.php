<?php

use MediaWiki\MainConfigNames;
use MediaWiki\Session\SessionManager;

class FauxRequestTest extends MediaWikiIntegrationTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->overrideConfigValue(MainConfigNames::Server, '//wiki.test');
    }

    /**
     * @covers FauxRequest::__construct
     */
    public function testConstructInvalidData()
    {
        $this->expectException(MWException::class);
        $this->expectExceptionMessage('bogus data');
        new FauxRequest('x');
    }

    /**
     * @covers FauxRequest::__construct
     */
    public function testConstructInvalidSession()
    {
        $this->expectException(MWException::class);
        $this->expectExceptionMessage('bogus session');
        new FauxRequest([], false, 'x');
    }

    /**
     * @covers FauxRequest::__construct
     */
    public function testConstructWithSession()
    {
        $session = SessionManager::singleton()->getEmptySession(new FauxRequest([]));
        $this->assertInstanceOf(
            FauxRequest::class,
            new FauxRequest([], false, $session)
        );
    }

    /**
     * @covers FauxRequest::getText
     */
    public function testGetText()
    {
        $req = new FauxRequest(['x' => 'Value']);
        $this->assertSame('Value', $req->getText('x'));
        $this->assertSame('', $req->getText('z'));
    }

    /**
     * Integration test for parent method
     * @covers FauxRequest::getVal
     */
    public function testGetVal()
    {
        $req = new FauxRequest(['crlf' => "A\r\nb"]);
        $this->assertSame("A\r\nb", $req->getVal('crlf'), 'CRLF');
    }

    /**
     * Integration test for parent method
     * @covers FauxRequest::getRawVal
     */
    public function testGetRawVal()
    {
        $req = new FauxRequest([
            'x'    => 'Value',
            'y'    => ['a'],
            'crlf' => "A\r\nb"
        ]);
        $this->assertSame('Value', $req->getRawVal('x'));
        $this->assertSame(null, $req->getRawVal('z'), 'Not found');
        $this->assertSame(null, $req->getRawVal('y'), 'Array is ignored');
        $this->assertSame("A\r\nb", $req->getRawVal('crlf'), 'CRLF');
    }

    /**
     * @covers FauxRequest::getValues
     */
    public function testGetValues()
    {
        $values = ['x' => 'Value', 'y' => ''];
        $req = new FauxRequest($values);
        $this->assertSame($values, $req->getValues());
    }

    /**
     * @covers FauxRequest::getQueryValues
     */
    public function testGetQueryValues()
    {
        $values = ['x' => 'Value', 'y' => ''];

        $req = new FauxRequest($values);
        $this->assertSame($values, $req->getQueryValues());
        $req = new FauxRequest($values, /*wasPosted*/ true);
        $this->assertSame([], $req->getQueryValues());
    }

    /**
     * @covers FauxRequest::getMethod
     */
    public function testGetMethod()
    {
        $req = new FauxRequest([]);
        $this->assertSame('GET', $req->getMethod());
        $req = new FauxRequest([], /*wasPosted*/ true);
        $this->assertSame('POST', $req->getMethod());
    }

    /**
     * @covers FauxRequest::wasPosted
     */
    public function testWasPosted()
    {
        $req = new FauxRequest([]);
        $this->assertFalse($req->wasPosted());
        $req = new FauxRequest([], /*wasPosted*/ true);
        $this->assertTrue($req->wasPosted());
    }

    /**
     * @covers FauxRequest::getCookie
     * @covers FauxRequest::setCookie
     * @covers FauxRequest::setCookies
     */
    public function testCookies()
    {
        $req = new FauxRequest();
        $this->assertSame(null, $req->getCookie('z', ''));

        $req->setCookie('x', 'Value', '');
        $this->assertSame('Value', $req->getCookie('x', ''));

        $req->setCookies(['x' => 'One', 'y' => 'Two'], '');
        $this->assertSame('One', $req->getCookie('x', ''));
        $this->assertSame('Two', $req->getCookie('y', ''));
    }

    /**
     * @covers FauxRequest::getCookie
     * @covers FauxRequest::setCookie
     * @covers FauxRequest::setCookies
     */
    public function testCookiesDefaultPrefix()
    {
        global $wgCookiePrefix;
        $oldPrefix = $wgCookiePrefix;
        $wgCookiePrefix = '_';

        $req = new FauxRequest();
        $this->assertSame(null, $req->getCookie('z'));

        $req->setCookie('x', 'Value');
        $this->assertSame('Value', $req->getCookie('x'));

        $wgCookiePrefix = $oldPrefix;
    }

    /**
     * @covers FauxRequest::getRequestURL
     */
    public function testGetRequestURL_disallowed()
    {
        $req = new FauxRequest();
        $this->expectException(MWException::class);
        $req->getRequestURL();
    }

    /**
     * @covers FauxRequest::setRequestURL
     * @covers FauxRequest::getRequestURL
     */
    public function testSetRequestURL()
    {
        $req = new FauxRequest();
        $req->setRequestURL('https://example.org');
        $this->assertSame('https://example.org', $req->getRequestURL());
    }

    /**
     * @covers FauxRequest::getFullRequestURL
     */
    public function testGetFullRequestURL_disallowed()
    {
        $req = new FauxRequest();

        $this->expectException(MWException::class);
        $req->getFullRequestURL();
    }

    /**
     * @covers FauxRequest::getFullRequestURL
     */
    public function testGetFullRequestURL_http()
    {
        $req = new FauxRequest();
        $req->setRequestURL('/path');

        $this->assertSame(
            'http://wiki.test/path',
            $req->getFullRequestURL()
        );
    }

    /**
     * @covers FauxRequest::getFullRequestURL
     */
    public function testGetFullRequestURL_https()
    {
        $req = new FauxRequest([], false, null, 'https');
        $req->setRequestURL('/path');

        $this->assertSame(
            'https://wiki.test/path',
            $req->getFullRequestURL()
        );
    }

    /**
     * @covers FauxRequest::__construct
     * @covers FauxRequest::getProtocol
     */
    public function testProtocol()
    {
        $req = new FauxRequest();
        $this->assertSame('http', $req->getProtocol());
        $req = new FauxRequest([], false, null, 'http');
        $this->assertSame('http', $req->getProtocol());
        $req = new FauxRequest([], false, null, 'https');
        $this->assertSame('https', $req->getProtocol());
    }

    /**
     * @covers FauxRequest::setHeader
     * @covers FauxRequest::setHeaders
     * @covers FauxRequest::getHeader
     */
    public function testGetSetHeader()
    {
        $value = 'text/plain, text/html';

        $request = new FauxRequest();
        $request->setHeader('Accept', $value);

        $this->assertSame(false, $request->getHeader('Nonexistent'));
        $this->assertSame($value, $request->getHeader('Accept'));
        $this->assertSame($value, $request->getHeader('ACCEPT'));
        $this->assertSame($value, $request->getHeader('accept'));
        $this->assertSame(
            ['text/plain', 'text/html'],
            $request->getHeader('Accept', WebRequest::GETHEADER_LIST)
        );
    }

    /**
     * @covers FauxRequest::initHeaders
     */
    public function testGetAllHeaders()
    {
        $_SERVER['HTTP_TEST'] = 'Example';

        $request = new FauxRequest();

        $this->assertSame([], $request->getAllHeaders());
        $this->assertSame(false, $request->getHeader('test'));
    }

    /**
     * @covers FauxRequest::__construct
     * @covers FauxRequest::getSessionArray
     */
    public function testSessionData()
    {
        $values = ['x' => 'Value', 'y' => ''];

        $req = new FauxRequest([], false, /*session*/ $values);
        $this->assertSame($values, $req->getSessionArray());

        $req = new FauxRequest();
        $this->assertSame(null, $req->getSessionArray());
    }

    /**
     * @covers FauxRequest::getPostValues
     */
    public function testGetPostValues()
    {
        $values = ['x' => 'Value', 'y' => ''];

        $req = new FauxRequest($values, true);
        $this->assertSame($values, $req->getPostValues());

        $req = new FauxRequest($values);
        $this->assertSame([], $req->getPostValues());
    }

    /**
     * @covers FauxRequest::getRawQueryString
     * @covers FauxRequest::getRawPostString
     * @covers FauxRequest::getRawInput
     */
    public function testDummies()
    {
        $req = new FauxRequest();
        $this->assertSame('', $req->getRawQueryString());
        $this->assertSame('', $req->getRawPostString());
        $this->assertSame('', $req->getRawInput());
    }
}
