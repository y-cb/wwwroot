<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace lib\phpoffice\phpword\src\PhpWord\Writer\Word2007\Part;

use lib\phpoffice\common\src\Common\XMLWriter;
use lib\phpoffice\phpword\src\PhpWord\Exception\Exception;
use lib\phpoffice\phpword\src\PhpWord\Settings;
use lib\phpoffice\phpword\src\PhpWord\Writer\AbstractWriter;

/**
 * Class AbstractPart
 *
 * @package lib\phpoffice\phpword\src\PhpWord\Writer\Word2007\Part
 */
abstract class AbstractPart
{
    /**
     * Parent writer
     *
     * @var \lib\phpoffice\phpword\src\PhpWord\Writer\AbstractWriter
     */
    protected $parentWriter;

    /**
     * @var string Date format
     */
    protected $dateFormat = 'Y-m-d\TH:i:sP';

    /**
     * Write part
     *
     * @return string
     */
    abstract public function write();

    /**
     * Set parent writer.
     *
     * @param \lib\phpoffice\phpword\src\PhpWord\Writer\AbstractWriter $writer
     */
    public function setParentWriter(AbstractWriter $writer = null)
    {
        $this->parentWriter = $writer;
    }

    /**
     * Get parent writer
     *
     * @throws \lib\phpoffice\phpword\src\PhpWord\Exception\Exception
     * @return \lib\phpoffice\phpword\src\PhpWord\Writer\AbstractWriter
     */
    public function getParentWriter()
    {
        if (!is_null($this->parentWriter)) {
            return $this->parentWriter;
        }
        throw new Exception('No parent WriterInterface assigned.');
    }

    /**
     * Get XML Writer
     *
     * @return \lib\phpoffice\common\src\Common\XMLWriter
     */
    protected function getXmlWriter()
    {
        $useDiskCaching = false;
        if (!is_null($this->parentWriter)) {
            if ($this->parentWriter->isUseDiskCaching()) {
                $useDiskCaching = true;
            }
        }
        if ($useDiskCaching) {
            return new XMLWriter(XMLWriter::STORAGE_DISK, $this->parentWriter->getDiskCachingDirectory(), Settings::hasCompatibility());
        }

        return new XMLWriter(XMLWriter::STORAGE_MEMORY, './', Settings::hasCompatibility());
    }

    /**
     * Write an XML text, this will call text() or writeRaw() depending on the value of Settings::isOutputEscapingEnabled()
     *
     * @param string $content The text string to write
     * @return bool Returns true on success or false on failure
     */
    protected function writeText($content)
    {
        if (Settings::isOutputEscapingEnabled()) {
            return $this->getXmlWriter()->text($content);
        }

        return $this->getXmlWriter()->writeRaw($content);
    }
}
