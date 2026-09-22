<?php

namespace lib\phpoffice\common\src\Common\Tests\Adapter\Zip;

use lib\phpoffice\common\src\Common\Adapter\Zip\PclZipAdapter;
use lib\phpoffice\common\src\Common\Tests\TestHelperZip;

class PclZipAdapterTest extends AbstractZipAdapterTest
{
    protected function createAdapter()
    {
        return new PclZipAdapter();
    }
}
