<?php

use Wikimedia\TestingAccessWrapper;

/**
 * @group FileRepo
 * @group FileBackend
 * @group medium
 *
 * @covers SwiftFileBackend
 * @covers SwiftFileBackendDirList
 * @covers SwiftFileBackendFileList
 * @covers SwiftFileBackendList
 */
class SwiftFileBackendTest extends MediaWikiIntegrationTestCase
{
    /** @var TestingAccessWrapper|SwiftFileBackend */
    private $backend;

    protected function setUp(): void
    {
        parent::setUp();

        $this->backend = TestingAccessWrapper::newFromObject(
            new SwiftFileBackend([
                'name'            => 'local-swift-testing',
                'class'           => SwiftFileBackend::class,
                'wikiId'          => 'unit-testing',
                'lockManager'     => $this->getServiceContainer()->getLockManagerGroupFactory()
                    ->getLockManagerGroup()->get('fsLockManager'),
                'swiftAuthUrl'    => 'http://127.0.0.1:8080/auth', // unused
                'swiftUser'       => 'test:tester',
                'swiftKey'        => 'testing',
                'swiftTempUrlKey' => 'b3968d0207b54ece87cccc06515a89d4' // unused
            ])
        );
    }

    /**
     * @covers       SwiftFileBackend::extractMutableContentHeaders
     * @dataProvider provider_testExtractPostableContentHeaders
     */
    public function testExtractPostableContentHeaders($raw, $sanitized)
    {
        $hdrs = $this->backend->extractMutableContentHeaders($raw);

        $this->assertEquals($sanitized, $hdrs, 'Correct extractPostableContentHeaders() result');
    }

    public static function provider_testExtractPostableContentHeaders()
    {
        return [
            'empty' => [
                [],
                []
            ],
            [
                [
                    'content-length'      => 345,
                    'content-type'        => 'image+bitmap/jpeg',
                    'content-disposition' => 'inline',
                    'content-duration'    => 35.6363,
                    'content-Custom'      => 'hello',
                    'x-content-custom'    => 'hello'
                ],
                [
                    'content-type'        => 'image+bitmap/jpeg',
                    'content-disposition' => 'inline',
                    'content-duration'    => 35.6363,
                    'content-custom'      => 'hello',
                    'x-content-custom'    => 'hello'
                ]
            ],
            [
                [
                    'content-length'      => 345,
                    'content-type'        => 'image+bitmap/jpeg',
                    'content-Disposition' => 'inline; filename=xxx; ' . str_repeat('o', 1024),
                    'content-duration'    => 35.6363,
                    'content-custom'      => 'hello',
                    'x-content-custom'    => 'hello'
                ],
                [
                    'content-type'        => 'image+bitmap/jpeg',
                    'content-disposition' => 'inline; filename=xxx',
                    'content-duration'    => 35.6363,
                    'content-custom'      => 'hello',
                    'x-content-custom'    => 'hello'
                ]
            ],
            [
                [
                    'content-length'      => 345,
                    'content-type'        => 'image+bitmap/jpeg',
                    'content-disposition' => 'filename=' . str_repeat('o', 1024) . ';inline',
                    'content-duration'    => 35.6363,
                    'content-custom'      => 'hello',
                    'x-content-custom'    => 'hello'
                ],
                [
                    'content-type'        => 'image+bitmap/jpeg',
                    'content-disposition' => '',
                    'content-duration'    => 35.6363,
                    'content-custom'      => 'hello',
                    'x-content-custom'    => 'hello'
                ]
            ],
            [
                [
                    'x-delete-at'      => 'non numeric',
                    'x-delete-after'   => 'non numeric',
                    'x-content-custom' => 'hello'
                ],
                [
                    'x-content-custom' => 'hello'
                ]
            ],
            [
                [
                    'x-delete-at'    => '12345',
                    'x-delete-after' => '12345'
                ],
                [
                    'x-delete-at'    => '12345',
                    'x-delete-after' => '12345'
                ]
            ],
            [
                [
                    'x-delete-at'    => 12345,
                    'x-delete-after' => 12345
                ],
                [
                    'x-delete-at'    => 12345,
                    'x-delete-after' => 12345
                ]
            ]
        ];
    }

    /**
     * @covers       SwiftFileBackend::extractMetadataHeaders
     * @dataProvider provider_testGetMetadataHeaders
     */
    public function testGetMetadataHeaders($raw, $sanitized)
    {
        $hdrs = $this->backend->extractMetadataHeaders($raw);

        $this->assertEquals($sanitized, $hdrs, 'getMetadataHeaders() has unexpected result');
    }

    public static function provider_testGetMetadataHeaders()
    {
        return [
            [
                [
                    'content-length'           => 345,
                    'content-custom'           => 'hello',
                    'x-content-custom'         => 'hello',
                    'x-object-meta-custom'     => 5,
                    'x-object-meta-sha1Base36' => 'a3deadfg...',
                ],
                [
                    'x-object-meta-custom'     => 5,
                    'x-object-meta-sha1base36' => 'a3deadfg...',
                ]
            ]
        ];
    }

    /**
     * @covers       SwiftFileBackend::getMetadataFromHeaders
     * @dataProvider provider_testGetMetadata
     */
    public function testGetMetadata($raw, $sanitized)
    {
        $hdrs = $this->backend->getMetadataFromHeaders($raw);

        $this->assertEquals($sanitized, $hdrs, 'getMetadata() has unexpected result');
    }

    public static function provider_testGetMetadata()
    {
        return [
            [
                [
                    'content-length'           => 345,
                    'content-custom'           => 'hello',
                    'x-content-custom'         => 'hello',
                    'x-object-meta-custom'     => 5,
                    'x-object-meta-sha1Base36' => 'a3deadfg...',
                ],
                [
                    'custom'     => 5,
                    'sha1base36' => 'a3deadfg...',
                ]
            ]
        ];
    }
}
