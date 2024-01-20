<?php

namespace App\Actions\Ebay;

class CreateDeleteXmlAction
{
    public function execute(array $parts): string
    {
        $fileName = $this->fileName();
        $path = base_path("public/exports/$fileName.xml");

        $xml = new \SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?><deleteRequest></deleteRequest>'
        );

        foreach($parts as $part) {
            $delete = $xml->addChild('delete');

            $delete->addChild('SKU', $part['article_nr']);
            $delete->addChild('action','DeleteInventory');
        }

        $xml->asXML($path);
        return $path;
    }

    private function fileName(): string
    {
        return "delete-inventory-" . now();
    }
}
