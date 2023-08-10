<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Uploads;

use Nette\Http\FileUpload;


final class Receiver
{
	public function getContainer(FileUpload $fileUpload): Container
	{
		return new Container($fileUpload);
	}


	public function save(FileUpload $fileUpload, callable $callback): void
	{
		call_user_func($callback, $this->getContainer($fileUpload));
	}
}
