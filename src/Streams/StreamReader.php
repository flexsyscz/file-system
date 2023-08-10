<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Streams;


interface StreamReader
{
	public function open(string $filePath): self;

	public function read(): mixed;

	public function close(): self;
}
