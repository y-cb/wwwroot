<?php

namespace lib\phpoffice\common\src\Common\Tests\Adapter\Zip;

use lib\phpoffice\common\src\Common\Adapter\Zip\ZipArchiveAdapter;
use lib\phpoffice\common\src\Common\Tests\TestHelperZip;

class ZipArchiveAdapterTest extends AbstractZipAdapterTest
{
    protected function createAdapter()
    {
        return new ZipArchiveAdapter();
    }
}
