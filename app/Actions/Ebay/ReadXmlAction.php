<?php

namespace App\Actions\Ebay;

use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ReadXmlAction
{
    private $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('ebay_ftp');
    }

    /**
     * @throws RuntimeException
     */
    public function execute(string $path): string
    {
        if (!$this->disk->exists($path)) {
            throw new RuntimeException("File not found at path: $path");
        }

        $file = $this->disk->get($path);
        $xml = new \SimpleXMLElement($file);

        // TESTING

        logger()->info((string) $xml->feedResponse);
    }
}
