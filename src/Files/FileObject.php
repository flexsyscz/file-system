<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Files;

use Nette\Utils\Image;
use Nette\Utils\ImageColor;
use Nette\Utils\ImageException;


trait FileObject
{
	public readonly bool $isImage;
	public readonly string $name;
	public readonly int $size;
	public readonly ?string $type;


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

			$this->isImage = in_array($this->type, $types, true);
		}

		return $this->isImage;
	}
}
