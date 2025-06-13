<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Uploads;

use Flexsyscz\FileSystem\Files\FileObject;
use Flexsyscz\FileSystem\Files\ImageFile;
use Flexsyscz\FileSystem\Exceptions\InvalidArgumentException;
use Flexsyscz\FileSystem\Files\ImageHelper;
use Nette\Http\FileUpload;
use Nette\Utils\Image;
use Nette\Utils\ImageException;
use Nette\Utils\Random;


final class Container implements ImageFile
{
	use FileObject;


	public function __construct(private readonly FileUpload $fileUpload)
	{
		$this->name = $fileUpload->getSanitizedName();
		$this->size = $fileUpload->getSize();
		$this->type = $fileUpload->getContentType();
		$this->isImage = $fileUpload->isImage();
	}


	public function isOk(): bool
	{
		return $this->fileUpload->isOk();
	}


	public function getError(): int
	{
		return $this->fileUpload->getError();
	}


	/**
	 * @param int $length
	 * @param string $charsetMask
	 * @param callable|null $mapper
	 * @return string
	 */
	public function getRandomizedName(int $length = 10, string $charsetMask = '0-9a-z', ?callable $mapper = null): string
	{
		if($length < 1) {
			throw new InvalidArgumentException('Length must be equal or greater than 1.');
		}

		if (empty($charsetMask)) {
			throw new InvalidArgumentException('Mask of charset must be defined.');
		}

		$prefix = Random::generate($length, $charsetMask);
		return $mapper ? call_user_func($mapper, $prefix, $this->name) : sprintf('%s_%s', $prefix, $this->name);
	}


	/**
	 * @param int|string|null $width
	 * @param int|string|null $height
	 * @param int-mask-of<Image::OrSmaller|Image::OrBigger|Image::Stretch|Image::Cover|Image::ShrinkOnly> $flags
	 * @return Image
	 * @throws ImageException
	 */
	public function getOptimizedImage(int|string|null $width = null, int|string|null $height = null, int $flags = Image::OrSmaller): Image
	{
		return ImageHelper::getOptimizedImage($this->fileUpload);
	}
}
