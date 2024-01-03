<?php

namespace App\Actions\Ebay;

use Illuminate\Support\Facades\Storage;
use RuntimeException;
use SimpleXMLElement;

class ReadXmlAction
{
    private $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('ebay_sftp');
    }

    /**
     * @throws RuntimeException
     */
    public function execute(string $dir): string
    {
        if (!$this->disk->exists($dir)) {
            throw new RuntimeException("File not found at path: $dir");
        }

        $filePaths = $this->disk->allFiles($dir);

        foreach ($filePaths as $path) {
            $file = $this->disk->get($path);

            $xml = new SimpleXMLElement($file);

            foreach ($xml->feedDetails->children() as $productDetail) {
                if ($productDetail->getName() === 'productDetail') {
                    $status = (string)$productDetail->status;
                    $messageID = (string)$productDetail->messages->messageInfo->messageID;
                    $message = (string)$productDetail->messages->messageInfo->message;

                    logger("status: $status message: $message");
                }
            }
        }


        return 'done';
    }
}
