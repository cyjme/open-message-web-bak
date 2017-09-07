<?php
namespace phpunit\Gap\Test\Config;

use Gap\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $config = new Config([
            'db' => [
                'default' => [
                    'adapter' => 'pdo',
                    'host' => 'localhost'
                ]
            ],
            'autoload' => [
                'psr4' => [
                    'Ipar' => '/path/to/ipar/src'
                ]
            ]
        ]);

        $config->set('db.default.host', '127.0.0.1');
        $config->set('autoload', [
            'psr4' => [
                'Ipar/Search' => '/path/to/ipar/search/src'
            ]
        ]);

        $this->assertEquals('pdo', $config->get('db.default.adapter'));
        $this->assertEquals('127.0.0.1', $config->get('db.default.host'));
        $this->assertEquals(
            [
                'Ipar' => '/path/to/ipar/src',
                'Ipar/Search' => '/path/to/ipar/search/src'
            ],
            $config->get('autoload.psr4')
        );
        $this->assertEquals('127.0.0.1', $config->getConfig('db.default')->get('host'));
    }
}
