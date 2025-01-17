<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Directories;

use Nette\Utils\FileSystem;


abstract class Directory
{
	protected string $dirPath;
	private DocumentRoot $documentRoot;


	public function __construct(string $dirPath, DocumentRoot $documentRoot, bool $autoCreateDir = true)
	{
		$this->dirPath = FileSystem::normalizePath($dirPath);
		$this->documentRoot = $documentRoot;

		if ($autoCreateDir && !$this->exists()) {
			$this->createDir('');
		}
	}


	public function getRelativePath(string $path): string
	{
		return (string) preg_replace('#^/#', '', str_replace($this->documentRoot->path, '', $this->getAbsolutePath($path)));
	}


	public function getAbsolutePath(string $relativePath = null): string
	{
		return $this->dirPath . ($relativePath ? DIRECTORY_SEPARATOR . $relativePath : '');
	}


	public function read(string $relativePath): string
	{
		return FileSystem::read($this->getAbsolutePath($relativePath));
	}


	public function readLines(string $relativePath, bool $stripNewLines = true): \Generator
	{
		return FileSystem::readLines($this->getAbsolutePath($relativePath), $stripNewLines);
	}


	public function write(string $relativePath, string $data, ?int $mode = 0666): void
	{
		FileSystem::write($this->getAbsolutePath($relativePath), $data, $mode);
	}


	public function rename(string $origin, string $target, bool $overwrite = true): void
	{
		FileSystem::rename($this->getAbsolutePath($origin), $this->getAbsolutePath($target), $overwrite);
	}


	public function copy(string $origin, string $target, bool $overwrite = true): void
	{
		FileSystem::copy($this->getAbsolutePath($origin), $this->getAbsolutePath($target), $overwrite);
	}


	public function createDir(string $relativePath, int $mode = 0777): void
	{
		FileSystem::createDir($this->getAbsolutePath($relativePath), $mode);
	}


	public function delete(string $relativePath = null): void
	{
		FileSystem::delete($this->getAbsolutePath($relativePath));
	}


	public function exists(string $relativePath = null): bool
	{
		return file_exists($this->getAbsolutePath($relativePath));
	}
}
