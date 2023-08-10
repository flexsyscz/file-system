<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Streams;


interface StreamWriter
{
	public function open(string $filePath): self;

	/**
	 * @param array<string>|string $data
	 * @return StreamWriter
	 */
	public function write(array|string $data): self;

	public function close(): self;
}
