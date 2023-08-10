<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Files;

use Nette\Http\FileUpload;


trait FileObject
{
	private bool $isImage;
	private string $name;
	private int $size;
	private ?string $type;


	public function isImage(): bool
	{
		if (!isset($this->isImage)) {
			$this->isImage = in_array($this->getType(), FileUpload::ImageMimeTypes, true);
		}

		return $this->isImage;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getSize(): int
	{
		return $this->size;
	}


	public function getType(): ?string
	{
		return $this->type;
	}
}
