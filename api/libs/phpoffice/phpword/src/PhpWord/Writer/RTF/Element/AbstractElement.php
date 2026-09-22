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

namespace lib\phpoffice\phpword\src\PhpWord\Writer\RTF\Element;

use lib\phpoffice\common\src\Common\Text as CommonText;
use lib\phpoffice\phpword\src\PhpWord\Element\AbstractElement as Element;
use lib\phpoffice\phpword\src\PhpWord\Escaper\Rtf;
use lib\phpoffice\phpword\src\PhpWord\Settings;
use lib\phpoffice\phpword\src\PhpWord\Style;
use lib\phpoffice\phpword\src\PhpWord\Style\Font as FontStyle;
use lib\phpoffice\phpword\src\PhpWord\Style\Paragraph as ParagraphStyle;
use lib\phpoffice\phpword\src\PhpWord\Writer\AbstractWriter;
use lib\phpoffice\phpword\src\PhpWord\Writer\HTML\Element\AbstractElement as HTMLAbstractElement;
use lib\phpoffice\phpword\src\PhpWord\Writer\RTF\Style\Font as FontStyleWriter;
use lib\phpoffice\phpword\src\PhpWord\Writer\RTF\Style\Paragraph as ParagraphStyleWriter;

/**
 * Abstract RTF element writer
 *
 * @since 0.11.0
 */
abstract class AbstractElement extends HTMLAbstractElement
{
    /**
     * Font style
     *
     * @var \lib\phpoffice\phpword\src\PhpWord\Style\Font
     */
    private $fontStyle;

    /**
     * Paragraph style
     *
     * @var \lib\phpoffice\phpword\src\PhpWord\Style\Paragraph
     */
    private $paragraphStyle;

    public function __construct(AbstractWriter $parentWriter, Element $element, $withoutP = false)
    {
        parent::__construct($parentWriter, $element, $withoutP);

        $this->escaper = new Rtf();
    }

    /**
     * Get font and paragraph styles.
     */
    protected function getStyles()
    {
        /** @var \lib\phpoffice\phpword\src\PhpWord\Writer\RTF $parentWriter Type hint */
        $parentWriter = $this->parentWriter;

        /** @var \lib\phpoffice\phpword\src\PhpWord\Element\Text $element Type hint */
        $element = $this->element;

        // Font style
        if (method_exists($element, 'getFontStyle')) {
            $this->fontStyle = $element->getFontStyle();
            if (is_string($this->fontStyle)) {
                $this->fontStyle = Style::getStyle($this->fontStyle);
            }
        }

        // Paragraph style
        if (method_exists($element, 'getParagraphStyle')) {
            $this->paragraphStyle = $element->getParagraphStyle();
            if (is_string($this->paragraphStyle)) {
                $this->paragraphStyle = Style::getStyle($this->paragraphStyle);
            }

            if ($this->paragraphStyle !== null && !$this->withoutP) {
                if ($parentWriter->getLastParagraphStyle() != $element->getParagraphStyle()) {
                    $parentWriter->setLastParagraphStyle($element->getParagraphStyle());
                } else {
                    $parentWriter->setLastParagraphStyle();
                    $this->paragraphStyle = null;
                }
            } else {
                $parentWriter->setLastParagraphStyle();
                $this->paragraphStyle = null;
            }
        }
    }

    /**
     * Write opening
     *
     * @return string
     */
    protected function writeOpening()
    {
        if ($this->withoutP || !$this->paragraphStyle instanceof ParagraphStyle) {
            return '';
        }

        $styleWriter = new ParagraphStyleWriter($this->paragraphStyle);
        $styleWriter->setNestedLevel($this->element->getNestedLevel());

        return $styleWriter->write();
    }

    /**
     * Write text
     *
     * @param string $text
     * @return string
     */
    protected function writeText($text)
    {
        if (Settings::isOutputEscapingEnabled()) {
            return $this->escaper->escape($text);
        }

        return CommonText::toUnicode($text); // todo: replace with `return $text;` later.
    }

    /**
     * Write closing
     *
     * @return string
     */
    protected function writeClosing()
    {
        if ($this->withoutP) {
            return '';
        }

        return '\par' . PHP_EOL;
    }

    /**
     * Write font style
     *
     * @return string
     */
    protected function writeFontStyle()
    {
        if (!$this->fontStyle instanceof FontStyle) {
            return '';
        }

        /** @var \lib\phpoffice\phpword\src\PhpWord\Writer\RTF $parentWriter Type hint */
        $parentWriter = $this->parentWriter;

        // Create style writer and set color/name index
        $styleWriter = new FontStyleWriter($this->fontStyle);
        if ($this->fontStyle->getColor() != null) {
            $colorIndex = array_search($this->fontStyle->getColor(), $parentWriter->getColorTable());
            if ($colorIndex !== false) {
                $styleWriter->setColorIndex($colorIndex + 1);
            }
        }
        if ($this->fontStyle->getName() != null) {
            $fontIndex = array_search($this->fontStyle->getName(), $parentWriter->getFontTable());
            if ($fontIndex !== false) {
                $styleWriter->setNameIndex($fontIndex);
            }
        }

        // Write style
        $content = $styleWriter->write();

        return $content;
    }
}
