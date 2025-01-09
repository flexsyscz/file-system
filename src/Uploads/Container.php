<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Uploads;

use Flexsyscz\FileSystem\Files\FileDescriptor;
use Flexsyscz\FileSystem\Files\FileObject;
use Flexsyscz\FileSystem\InvalidArgumentException;
use Nette\Http\FileUpload;
use Nette\Utils\Image;
use Nette\Utils\ImageColor;
use Nette\Utils\ImageException;
use Nette\Utils\Random;


final class Container implements FileDescriptor
{
	use FileObject;

	private FileUpload $fileUpload;


	public function __construct(FileUpload $fileUpload)
	{
		$this->fileUpload = $fileUpload;

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


	public function getFileUpload(): FileUpload
	{
		return $this->fileUpload;
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


	/**
	 * @param int $length
	 * @param string $charlist
	 * @param string $mask
	 * @return string
	 */
	public function getRandomizedName(int $length = 10, string $charlist = '0-9a-z', string $mask = '%s_%s'): string
	{
		if($length < 1) {
			throw new InvalidArgumentException('Length must be equal or greater than 1.');
		}

		if (empty($charlist)) {
			throw new InvalidArgumentException('Charlist must be defined.');
		}

		return sprintf($mask, Random::generate($length, $charlist), $this->name);
	}
}
