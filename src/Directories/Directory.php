<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Directories;

use Nette\Utils\FileSystem;


trait Directory
{
	protected static string $dirPath;


	public static function setUp(string $dirPath, bool $autoCreateDir = true): void
	{
		self::$dirPath = FileSystem::normalizePath($dirPath);

		if ($autoCreateDir && !self::exists()) {
			self::createDir('');
		}
	}


	public static function getAbsolutePath(string $relativePath = null): string
	{
		return self::$dirPath . ($relativePath ? DIRECTORY_SEPARATOR . $relativePath : '');
	}


	public static function read(string $relativePath): string
	{
		return FileSystem::read(self::getAbsolutePath($relativePath));
	}


	public static function readLines(string $relativePath, bool $stripNewLines = true): \Generator
	{
		return FileSystem::readLines(self::getAbsolutePath($relativePath), $stripNewLines);
	}


	public static function write(string $relativePath, string $data, ?int $mode = 0666): void
	{
		FileSystem::write(self::getAbsolutePath($relativePath), $data, $mode);
	}


	public static function rename(string $origin, string $target, bool $overwrite = true): void
	{
		FileSystem::rename(self::getAbsolutePath($origin), self::getAbsolutePath($target), $overwrite);
	}


	public static function copy(string $origin, string $target, bool $overwrite = true): void
	{
		FileSystem::copy(self::getAbsolutePath($origin), self::getAbsolutePath($target), $overwrite);
	}


	public static function createDir(string $relativePath, int $mode = 0777): void
	{
		FileSystem::createDir(self::getAbsolutePath($relativePath), $mode);
	}


	public static function delete(string $relativePath = null): void
	{
		FileSystem::delete(self::getAbsolutePath($relativePath));
	}


	public static function exists(string $relativePath = null): bool
	{
		return file_exists(self::getAbsolutePath($relativePath));
	}
}
