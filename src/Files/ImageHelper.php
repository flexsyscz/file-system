<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Files;

use Nette\Http\FileUpload;
use Nette\Utils\Image;
use Nette\Utils\ImageColor;
use Nette\Utils\ImageException;


class ImageHelper
{
	/**
	 * @param string|FileUpload $file
	 * @param int|string|null $width
	 * @param int|string|null $height
	 * @param int-mask-of<Image::OrSmaller|Image::OrBigger|Image::Stretch|Image::Cover|Image::ShrinkOnly> $flags
	 * @return Image
	 * @throws ImageException
	 */
	public static function getOptimizedImage(string|FileUpload $file, int|string|null $width = null, int|string|null $height = null, int $flags = Image::OrSmaller): Image
	{
			$exif = @exif_read_data($file instanceof FileUpload ? $file->getTemporaryFile() : $file);
			$image = $file instanceof FileUpload ? $file->toImage() : Image::fromFile($file);
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
