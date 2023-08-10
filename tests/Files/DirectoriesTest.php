<?php

declare(strict_types=1);

namespace Tests\Files;

use DateTimeImmutable;
use Flexsyscz;
use Nette\Utils\FileSystem;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class DirectoriesTest extends TestCase
{
	public function setUp(): void
	{
		Flexsyscz\FileSystem\Directories\AppDirectory::setUp(__DIR__ . '/../Resources/app');
		Flexsyscz\FileSystem\Directories\LogDirectory::setUp(__DIR__ . '/../Resources/log');
		Flexsyscz\FileSystem\Directories\TempDirectory::setUp(__DIR__ . '/../Resources/temp');
		Flexsyscz\FileSystem\Directories\WwwDirectory::setUp(__DIR__ . '/../Resources/www');
		Flexsyscz\FileSystem\Directories\AssetsDirectory::setUp(__DIR__ . '/../Resources/www/assets');
		Flexsyscz\FileSystem\Directories\DataDirectory::setUp(__DIR__ . '/../Resources/www/data');
	}


	public function testDirectories(): void
	{
		// App
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/app'), Flexsyscz\FileSystem\Directories\AppDirectory::getAbsolutePath());

		Flexsyscz\FileSystem\Directories\AppDirectory::createDir('bin');
		Flexsyscz\FileSystem\Directories\AppDirectory::write('bin/test.txt', 'Test');

		Assert::true(Flexsyscz\FileSystem\Directories\AppDirectory::exists('bin/test.txt'));

		Flexsyscz\FileSystem\Directories\AppDirectory::delete();


		// Log
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/log'), Flexsyscz\FileSystem\Directories\LogDirectory::getAbsolutePath());

		Flexsyscz\FileSystem\Directories\LogDirectory::createDir('errors');
		Flexsyscz\FileSystem\Directories\LogDirectory::write('errors/error.log', 'Error');

		Assert::true(Flexsyscz\FileSystem\Directories\LogDirectory::exists('errors/error.log'));

		Flexsyscz\FileSystem\Directories\LogDirectory::delete();


		// Temp
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/temp'), Flexsyscz\FileSystem\Directories\TempDirectory::getAbsolutePath());

		Flexsyscz\FileSystem\Directories\TempDirectory::createDir('cache');
		Flexsyscz\FileSystem\Directories\TempDirectory::write('cache/test.txt', 'Data');

		Assert::true(Flexsyscz\FileSystem\Directories\TempDirectory::exists('cache/test.txt'));

		Flexsyscz\FileSystem\Directories\TempDirectory::delete();


		// Www
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/www'), Flexsyscz\FileSystem\Directories\WwwDirectory::getAbsolutePath());

		Flexsyscz\FileSystem\Directories\WwwDirectory::createDir('images');
		Flexsyscz\FileSystem\Directories\WwwDirectory::write('images/hello.jpg', 'Data');

		Assert::true(Flexsyscz\FileSystem\Directories\WwwDirectory::exists('images/hello.jpg'));

		Flexsyscz\FileSystem\Directories\WwwDirectory::delete();


		// Assets
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/www/assets'), Flexsyscz\FileSystem\Directories\AssetsDirectory::getAbsolutePath());

		Flexsyscz\FileSystem\Directories\AssetsDirectory::createDir('dist');
		Flexsyscz\FileSystem\Directories\AssetsDirectory::write('dist/main.js', 'JS');

		Assert::true(Flexsyscz\FileSystem\Directories\AssetsDirectory::exists('dist/main.js'));

		Flexsyscz\FileSystem\Directories\AssetsDirectory::delete();


		// Data
		Assert::equal(FileSystem::normalizePath(__DIR__ . '/../Resources/www/data'), Flexsyscz\FileSystem\Directories\DataDirectory::getAbsolutePath());

		Flexsyscz\FileSystem\Directories\DataDirectory::createDir('users');
		Flexsyscz\FileSystem\Directories\DataDirectory::write('users/profile.jpg', 'Photo');

		Assert::true(Flexsyscz\FileSystem\Directories\DataDirectory::exists('users/profile.jpg'));

		Flexsyscz\FileSystem\Directories\DataDirectory::delete();
	}
}

(new DirectoriesTest())->run();
