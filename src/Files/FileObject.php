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
			$flag = imagetypes();
			$types = array_filter([
				$flag & IMG_GIF ? 'image/gif' : null,
				$flag & IMG_JPG ? 'image/jpeg' : null,
				$flag & IMG_PNG ? 'image/png' : null,
				$flag & IMG_WEBP ? 'image/webp' : null,
				$flag & 256 ? 'image/avif' : null, // IMG_AVIF
			]);

			$this->isImage = in_array($this->getType(), $types, true);
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
