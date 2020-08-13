<?php

namespace BeyondCode\LaravelWebSockets\Tests\ClientProviders;

use BeyondCode\LaravelWebSockets\Apps\DatabaseAppProvider;
use BeyondCode\LaravelWebSockets\Models\DatabaseApp;
use BeyondCode\LaravelWebSockets\Tests\TestCase;
use Illuminate\Support\Str;

class DatabaseAppProviderTest extends TestCase
{
    /** @var DatabaseAppProvider */
    protected $databaseAppProvider;

    /** @var DatabaseApp */
    private $databaseApp;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseAppProvider = new DatabaseAppProvider();

        $this->databaseApp = DatabaseApp::create([
            'name' => 'Application One',
            'host' => "example-1.test",
            'key' => Str::random(),
            'secret' => Str::random(32),
            'enable_client_messages' => false,
            'enable_statistics' => true,
        ]);
    }

    /** @test */
    public function it_can_get_apps_from_the_database()
    {
        $apps = $this->databaseAppProvider->all();

        $this->assertCount(1, $apps);

        /** @var $app */
        $app = $apps[0];

        $this->assertEquals($this->databaseApp->name, $app->name);
        $this->assertEquals($this->databaseApp->id, $app->id);
        $this->assertEquals($this->databaseApp->key, $app->key);
        $this->assertEquals($this->databaseApp->secret, $app->secret);
        $this->assertFalse($app->clientMessagesEnabled);
        $this->assertTrue($app->statisticsEnabled);
    }

    /** @test */
    public function it_can_find_app_by_id()
    {
        $app = $this->databaseAppProvider->findById(0000);

        $this->assertNull($app);

        $app = $this->databaseAppProvider->findById($this->databaseApp->id);

        $this->assertEquals($this->databaseApp->name, $app->name);
        $this->assertEquals($this->databaseApp->id, $app->id);
        $this->assertEquals($this->databaseApp->key, $app->key);
        $this->assertEquals($this->databaseApp->secret, $app->secret);
        $this->assertFalse($app->clientMessagesEnabled);
        $this->assertTrue($app->statisticsEnabled);
    }

    /** @test */
    public function it_can_find_app_by_key()
    {
        $app = $this->databaseAppProvider->findByKey('InvalidKey');

        $this->assertNull($app);

        $app = $this->databaseAppProvider->findByKey($this->databaseApp->key);

        $this->assertEquals($this->databaseApp->name, $app->name);
        $this->assertEquals($this->databaseApp->id, $app->id);
        $this->assertEquals($this->databaseApp->key, $app->key);
        $this->assertEquals($this->databaseApp->secret, $app->secret);
        $this->assertFalse($app->clientMessagesEnabled);
        $this->assertTrue($app->statisticsEnabled);
    }

    /** @test */
    public function it_can_find_app_by_secret()
    {
        $app = $this->databaseAppProvider->findBySecret('InvalidSecret');

        $this->assertNull($app);

        $app = $this->databaseAppProvider->findBySecret($this->databaseApp->secret);

        $this->assertEquals($this->databaseApp->name, $app->name);
        $this->assertEquals($this->databaseApp->id, $app->id);
        $this->assertEquals($this->databaseApp->key, $app->key);
        $this->assertEquals($this->databaseApp->secret, $app->secret);
        $this->assertFalse($app->clientMessagesEnabled);
        $this->assertTrue($app->statisticsEnabled);
    }
}
