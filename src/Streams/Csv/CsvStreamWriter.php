<?php

declare(strict_types=1);

namespace Flexsyscz\FileSystem\Streams\Csv;

use Flexsyscz\FileSystem\Exceptions\StreamWriterException;
use Flexsyscz\FileSystem\Streams\StreamWriter;


class CsvStreamWriter implements StreamWriter
{
	public const Delimiter = ';';

	/** @var resource */
	private $file;


	public function open(string $filePath): StreamWriter
	{
		$file = fopen($filePath, 'w');
		if (!$file) {
			throw new StreamWriterException(sprintf('Unable to open a stream to the file %s', $filePath));
		}

		$this->file = $file;
		if (!flock($this->file, LOCK_EX)) {
			throw new StreamWriterException(sprintf('Unable to set a lock on the file %s', $filePath));
		}

		return $this;
	}


	/**
	 * @param array<string>|string $data
	 * @param string $delimiter
	 * @param string $enclosure
	 * @param string $escapeChar
	 * @return CsvStreamWriter
	 */
	public function write(
		$data,
		string $delimiter = self::Delimiter,
		string $enclosure = "'",
		string $escapeChar = '\\'
	): StreamWriter {
		if (!is_array($data) || fputcsv($this->file, $data, $delimiter, $enclosure, $escapeChar) === false) {
			throw new StreamWriterException('Unable to write the data into the CSV stream.');
		}

		return $this;
	}


	public function close(): StreamWriter
	{
		if (!flock($this->file, LOCK_UN)) {
			throw new StreamWriterException('Unable to release the file\'s lock.');
		}

		return $this;
	}
}
