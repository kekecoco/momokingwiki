<?php

use MediaWiki\Config\ServiceOptions;
use MediaWiki\JobQueue\JobQueueGroupFactory;
use Wikimedia\UUID\GlobalIdGenerator;

/**
 * @covers \MediaWiki\JobQueue\JobQueueGroupFactory
 */
class JobQueueGroupFactoryTest extends MediaWikiUnitTestCase
{
    public function testMakeJobQueueGroupReturnsSameInstance(): void
    {
        $factory = new JobQueueGroupFactory(
            new ServiceOptions(
                JobQueueGroupFactory::CONSTRUCTOR_OPTIONS,
                new HashConfig([
                    'LocalDatabases'                   => [],
                    'JobClasses'                       => [],
                    'JobTypeConf'                      => [],
                    'JobTypesExcludedFromDefaultQueue' => []
                ])
            ),
            $this->createMock(ConfiguredReadOnlyMode::class),
            $this->createMock(IBufferingStatsdDataFactory::class),
            $this->createMock(WANObjectCache::class),
            $this->createMock(GlobalIdGenerator::class)
        );

        $group = $factory->makeJobQueueGroup();

        $this->assertSame($group, $factory->makeJobQueueGroup());
    }
}
