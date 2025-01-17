<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Directories;


use Nette\Utils\FileSystem;

final class DocumentRoot
{
	public readonly string $path;


	public function __construct(string $path)
	{
		$this->path = FileSystem::normalizePath($path);
	}
}
