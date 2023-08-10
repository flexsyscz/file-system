<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Files;


interface FileDescriptor
{
	function isImage(): bool;
}
