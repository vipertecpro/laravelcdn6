<?php

namespace Vipertecpro\laravelcdn6\Test;

use Illuminate\Support\Collection;
use Mockery as M;
use Symfony\Component\Console\Output\ConsoleOutput;
use Aws\S3\S3Client;
use Aws\Command;
use Aws\Result;
use Vipertecpro\laravelcdn6\Validators\Contracts\ProviderValidatorInterface;
use Vipertecpro\laravelcdn6\CdnHelper;
use Symfony\Component\Finder\SplFileInfo;
use Vipertecpro\laravelcdn6\Providers\AwsS3Provider;

/**
 * Class AwsS3ProviderTest.
 *
 * @category Test
 *
 * @author   Vipul Walia <vipertecpro@gmail.com>
 */
class AwsS3ProviderTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();

        $this->url = 'http://www.google.com';
        $this->cdn_url = 'http://my-bucket-name.www.google.com/public/css/cool/style.css';
        $this->path = 'public/css/cool/style.css';
        $this->path_url = 'http://www.google.com/public/css/cool/style.css';
        $this->pased_url = parse_url($this->url);

        $this->m_console = M::mock(ConsoleOutput::class);
        $this->m_console->shouldReceive('writeln')->atLeast(2);

        $this->m_validator = M::mock(ProviderValidatorInterface::class);
        $this->m_validator->shouldReceive('validate');

        $this->m_helper = M::mock(CdnHelper::class);
        $this->m_helper->shouldReceive('parseUrl')
            ->andReturn($this->pased_url);

        $this->m_spl_file = M::mock(SplFileInfo::class);
        $this->m_spl_file->shouldReceive('getPathname')->andReturn('Vipertecpro/laravelcdn6/tests/Vipertecpro/laravelcdn6/AwsS3ProviderTest.php');
        $this->m_spl_file->shouldReceive('getRealPath')->andReturn(__DIR__.'/AwsS3ProviderTest.php');

        $this->p_awsS3Provider = M::mock('\Vipertecpro\laravelcdn6\Providers\AwsS3Provider[connect]', array(
            $this->m_console,
            $this->m_validator,
            $this->m_helper,
        ));

        $this->m_s3 = M::mock(S3Client::class);
        $this->m_s3->shouldReceive('factory')->andReturn(S3Client::class);
        $m_command = M::mock(Command::class);
        $this->m_s3->shouldReceive('getCommand')
            ->andReturn($m_command);
        $m_command1 = M::mock(Result::class)->shouldIgnoreMissing();
        $this->m_s3->shouldReceive('listObjects')
            ->andReturn($m_command1);
        $this->m_s3->shouldReceive('execute');
        $this->p_awsS3Provider->setS3Client($this->m_s3);

        $this->p_awsS3Provider->shouldReceive('connect')->andReturn(true);
    }

    public function tearDown():void
    {
        M::close();
        parent::tearDown();
    }

    public function testInitializingObject()
    {
        $configurations = [
            'default' => 'AwsS3',
            'url' => 'https://s3.amazonaws.com',
            'threshold' => 10,
            'providers' => [
                'aws' => [
                    's3' => [
                        'region' => 'us-standard',
                        'version' => 'latest',
                        'buckets' => [
                            'my-bucket-name' => '*',
                        ],
                        'acl' => 'public-read',
                        'cloudfront' => [
                            'use' => false,
                            'cdn_url' => null,
                        ],
                        'metadata' => [],
                        'expires' => gmdate('D, d M Y H:i:s T', strtotime('+5 years')),
                        'cache-control' => 'max-age=2628000',
                        'version' => null,
                        'http' => null,
                    ],
                ],
            ],
        ];

        $awsS3Provider_obj = $this->p_awsS3Provider->init($configurations);

        assertInstanceOf(AwsS3Provider::class, $awsS3Provider_obj);
    }

    public function testUploadingAssets()
    {
        $configurations = [
            'default' => 'AwsS3',
            'url' => 'https://s3.amazonaws.com',
            'threshold' => 10,
            'providers' => [
                'aws' => [
                    's3' => [
                        'region' => 'us-standard',
                        'version' => 'latest',
                        'buckets' => [
                            'my-bucket-name' => '*',
                        ],
                        'acl' => 'public-read',
                        'cloudfront' => [
                            'use' => false,
                            'cdn_url' => null,
                        ],
                        'metadata' => [],
                        'expires' => gmdate('D, d M Y H:i:s T', strtotime('+5 years')),
                        'cache-control' => 'max-age=2628000',
                        'version' => null,
                        'http' => null,
                    ],
                ],
            ],
        ];

        $this->p_awsS3Provider->init($configurations);

        $result = $this->p_awsS3Provider->upload(new Collection([$this->m_spl_file]));

        assertEquals(true, $result);
    }

    public function testUrlGenerator()
    {
        $configurations = [
            'default' => 'AwsS3',
            'url' => 'https://s3.amazonaws.com',
            'threshold' => 10,
            'providers' => [
                'aws' => [
                    's3' => [
                        'region' => 'us-standard',
                        'version' => 'latest',
                        'buckets' => [
                            'my-bucket-name' => '*',
                        ],
                        'acl' => 'public-read',
                        'cloudfront' => [
                            'use' => false,
                            'cdn_url' => null,
                        ],
                        'metadata' => [],
                        'expires' => gmdate('D, d M Y H:i:s T', strtotime('+5 years')),
                        'cache-control' => 'max-age=2628000',
                        'version' => null,
                        'http' => null,
                    ],
                ],
            ],
        ];

        $this->p_awsS3Provider->init($configurations);

        $result = $this->p_awsS3Provider->urlGenerator($this->path);

        assertEquals($this->cdn_url, $result);
    }

    public function testEmptyUrlGenerator()
    {
        $configurations = [
            'default' => 'AwsS3',
            'url' => 'https://s3.amazonaws.com',
            'threshold' => 10,
            'providers' => [
                'aws' => [
                    's3' => [
                        'region' => 'us-standard',
                        'version' => 'latest',
                        'buckets' => [
                            '' => '*',
                        ],
                        'acl' => 'public-read',
                        'cloudfront' => [
                            'use' => false,
                            'cdn_url' => null,
                        ],
                        'metadata' => [],
                        'expires' => gmdate('D, d M Y H:i:s T', strtotime('+5 years')),
                        'cache-control' => 'max-age=2628000',
                        'version' => null,
                        'http' => null,
                    ],
                ],
            ],
        ];

        $this->p_awsS3Provider->init($configurations);

        $result = $this->p_awsS3Provider->urlGenerator($this->path);

        assertEquals($this->path_url, $result);
    }
}
