<?php

declare(strict_types=1);

namespace Tests\Files;

use Flexsyscz;
use Flexsyscz\FileSystem\Directories\AppDirectory;
use Flexsyscz\FileSystem\Directories\AssetsDirectory;
use Flexsyscz\FileSystem\Directories\DataDirectory;
use Flexsyscz\FileSystem\Directories\LogDirectory;
use Flexsyscz\FileSystem\Directories\TempDirectory;
use Flexsyscz\FileSystem\Directories\RootDirectory;
use Flexsyscz\FileSystem\Directories\WwwDirectory;
use Nette\Utils\FileSystem;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class DirectoriesTest extends TestCase
{
	private RootDirectory $rootDir;
	private	AppDirectory $appDir;
	private LogDirectory $logDir;
	private TempDirectory $tempDir;
	private WwwDirectory $wwwDir;
	private AssetsDirectory $assetsDir;
	private DataDirectory $dataDir;


	public function setUp(): void
	{
		$this->rootDir = new RootDirectory(__DIR__ . '/../Resources');
		$this->appDir = new AppDirectory(__DIR__ . '/../Resources/app');
		$this->logDir = new LogDirectory(__DIR__ . '/../Resources/log');
		$this->tempDir = new TempDirectory(__DIR__ . '/../Resources/temp');
		$this->wwwDir = new WwwDirectory(__DIR__ . '/../Resources/www');
		$this->assetsDir = new AssetsDirectory(__DIR__ . '/../Resources/www/assets');
		$this->dataDir = new DataDirectory(__DIR__ . '/../Resources/www/data');
	}


	public function testDirectories(): void
	{
		// Root
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/app/..'), $this->rootDir->getAbsolutePath());
		Assert::equal('test', $this->rootDir->getRelativePath('test'));

		// App
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/app'), $this->appDir->getAbsolutePath());

		$this->appDir->createDir('bin');
		$this->appDir->write('bin/test.txt', 'Test');

		Assert::true($this->appDir->exists('bin/test.txt'));

		$this->appDir->delete();


		// Log
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/log'), $this->logDir->getAbsolutePath());

		$this->logDir->createDir('errors');
		$this->logDir->write('errors/error.log', 'Error');

		Assert::true($this->logDir->exists('errors/error.log'));

		$this->logDir->delete();


		// Temp
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/temp'), $this->tempDir->getAbsolutePath());

		$this->tempDir->createDir('cache');
		$this->tempDir->write('cache/test.txt', 'Data');

		Assert::true($this->tempDir->exists('cache/test.txt'));

		$this->tempDir->delete();


		// Www
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/www'), $this->wwwDir->getAbsolutePath());

		$this->wwwDir->createDir('images');
		$this->wwwDir->write('images/hello.jpg', 'Data');

		Assert::true($this->wwwDir->exists('images/hello.jpg'));

		$this->wwwDir->delete();


		// Assets
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/www/assets'), $this->assetsDir->getAbsolutePath());

		$this->assetsDir->createDir('dist');
		$this->assetsDir->write('dist/main.js', 'JS');

		Assert::true($this->assetsDir->exists('dist/main.js'));

		$this->assetsDir->delete();


		// Data
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/www/data'), $this->dataDir->getAbsolutePath());

		$this->dataDir->createDir('users');
		$this->dataDir->write('users/profile.jpg', 'Photo');

		Assert::true($this->dataDir->exists('users/profile.jpg'));

		$this->dataDir->delete();
	}
}

(new DirectoriesTest())->run();
