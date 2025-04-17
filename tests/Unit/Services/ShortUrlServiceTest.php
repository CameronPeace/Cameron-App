<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\ShortUrlService;
use App\Models\Repositories\ShortUrlRepository;
use App\Exceptions\ShortUrlServiceException;

class ShortUrlServiceTest extends TestCase
{
    private $shortUrlService;
    private $shortUrlRepositoryMock;

    protected function setUp(): void
    {
        $this->shortUrlRepositoryMock = $this->createMock(ShortUrlRepository::class);
        $this->shortUrlService = new ShortUrlService();

        // Use reflection to replace the repository with a mock
        $reflection = new \ReflectionClass($this->shortUrlService);
        $property = $reflection->getProperty('shortUrlRepository');
        $property->setAccessible(true);
        $property->setValue($this->shortUrlService, $this->shortUrlRepositoryMock);
    }

    public function testCreateShortUrlSuccess()
    {
        $redirect = 'https://example.com';
        $domain = 'test.com';
        $length = 6;
        $code = 'abc123';

        $this->shortUrlRepositoryMock
            ->method('create')
            ->willReturn(['code' => $code, 'redirect' => $redirect, 'domain' => $domain]);

        $this->shortUrlService->method('createNewCode')
            ->willReturn($code);

        $result = $this->shortUrlService->createShortUrl($redirect, $domain, $length);
        $this->assertEquals(['code' => $code, 'redirect' => $redirect, 'domain' => $domain], $result);
    }

    public function testCreateShortUrlException()
    {
        $this->expectException(ShortUrlServiceException::class);
        $redirect = 'https://example.com';
        $domain = 'test.com';
        $length = 6;

        $this->shortUrlRepositoryMock
            ->method('create')
            ->willThrowException(new \Exception('Database error'));

        $this->shortUrlService->method('createNewCode')
            ->willReturn('abc123');

        $this->shortUrlService->createShortUrl($redirect, $domain, $length);
    }

    public function testCreateNewCodeSuccess()
    {
        $domain = 'test.com';
        $length = 6;
        $code = 'abc123';

        $this->shortUrlRepositoryMock
            ->method('first')
            ->willReturn(null);

        $this->shortUrlService->method('generateRandomString')
            ->willReturn($code);

        $result = $this->shortUrlService->createNewCode($domain, $length);
        $this->assertEquals($code, $result);
    }

    public function testCreateNewCodeMaxTriesExceeded()
    {
        $this->expectException(ShortUrlServiceException::class);
        $domain = 'test.com';
        $length = 6;

        $this->shortUrlRepositoryMock
            ->method('first')
            ->willReturn(['code' => 'existing']);

        $this->shortUrlService->createNewCode($domain, $length);
    }

    public function testGetCodeDetailsSuccess()
    {
        $code = 'abc123';
        $domain = 'test.com';
        $details = ['code' => $code, 'redirect' => 'https://example.com', 'domain' => $domain];

        $this->shortUrlRepositoryMock
            ->method('getDetailsByCode')
            ->willReturn($details);

        $result = $this->shortUrlService->getCodeDetails($code, $domain);
        $this->assertEquals($details, $result);
    }

    public function testGetCodeDetailsException()
    {
        $this->expectException(ShortUrlServiceException::class);
        $code = 'abc123';
        $domain = 'test.com';

        $this->shortUrlRepositoryMock
            ->method('getDetailsByCode')
            ->willThrowException(new \Exception('Database error'));

        $this->shortUrlService->getCodeDetails($code, $domain);
    }

    public function testGetShortUrlSuccess()
    {
        $code = 'abc123';
        $domain = 'test.com';
        $shortUrl = ['code' => $code, 'redirect' => 'https://example.com', 'domain' => $domain];

        $this->shortUrlRepositoryMock
            ->method('first')
            ->willReturn($shortUrl);

        $result = $this->shortUrlService->getShortUrl($code, $domain);
        $this->assertEquals($shortUrl, $result);
    }

    public function testGetShortUrlException()
    {
        $this->expectException(ShortUrlServiceException::class);
        $code = 'abc123';
        $domain = 'test.com';

        $this->shortUrlRepositoryMock
            ->method('first')
            ->willThrowException(new \Exception('Database error'));

        $this->shortUrlService->getShortUrl($code, $domain);
    }

    public function testGetRedirectsSuccess()
    {
        $limit = 100;
        $orderByClicks = true;
        $redirects = [
            ['code' => 'abc123', 'redirect' => 'https://example.com', 'clicks' => 10],
            ['code' => 'def456', 'redirect' => 'https://example.org', 'clicks' => 5]
        ];

        $this->shortUrlRepositoryMock
            ->method('getRedirects')
            ->willReturn($redirects);

        $result = $this->shortUrlService->getRedirects($limit, $orderByClicks);
        $this->assertEquals($redirects, $result);
    }

    public function testGetRedirectsException()
    {
        $this->expectException(ShortUrlServiceException::class);
        $limit = 100;
        $orderByClicks = true;

        $this->shortUrlRepositoryMock
            ->method('getRedirects')
            ->willThrowException(new \Exception('Database error'));

        $this->shortUrlService->getRedirects($limit, $orderByClicks);
    }
}