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


	/**
	 * @param int|string|null $width
	 * @param int|string|null $height
	 * @param int-mask-of<Image::OrSmaller|Image::OrBigger|Image::Stretch|Image::Cover|Image::ShrinkOnly> $flags
	 * @return Image|null
	 * @throws ImageException
	 */
	public function getOptimizedImage(int|string $width = null, int|string $height = null, int $flags = Image::OrSmaller): ?Image
	{
		if ($this->isOk()) {
			if ($this->isImage()) {
				$exif = @exif_read_data($this->fileUpload->getTemporaryFile());
				$image = $this->fileUpload->toImage();
				if (is_array($exif) && !empty($exif['Orientation'])) {
					$backgroundColor = ImageColor::hex('#000');
					switch ($exif['Orientation']) {
						case 8:
							$image = $image->rotate(90, $backgroundColor);
							break;
						case 3:
							$image = $image->rotate(180, $backgroundColor);
							break;
						case 6:
							$image = $image->rotate(-90, $backgroundColor);
							break;
					}
				}

				if ($width || $height) {
					$image->resize($width, $height, $flags);
				}

				return $image;
			}
		}

		return null;
	}
}
