<?php

namespace Citra\CommonBundle\Extension\Assetic;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

/**
 * CompressorFilter is self explanatory. It does CSS compression.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CompressorFilter implements FilterInterface
{
    public function filterLoad(AssetInterface $asset)
    {
    }

    public function filterDump(AssetInterface $asset)
    {
        $content = $asset->getContent();
        $content = $this->compress($content);
        //Do something to $content
        $asset->setContent($content);
    }

    private function compress($content) {
        // -- The Reinhold Weber method
        // remove comments
        $pattern = '!/\*[^*]*\*+([^/][^*]*\*+)*/!';
        $content = preg_replace($pattern, '', $content);

        // remove tabs, spaces, newlines, etc.
        $search = array("\r\n", "\r", "\n", "\t", '  ', '    ', '    ');
        return str_replace($search, '', $content);
    }
}
