<?php
/**
 * This file is part of PHPOffice Common
 *
 * PHPOffice Common is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/Common/contributors.
 *
 * @link        https://github.com/PHPOffice/Common
 * @copyright   2009-2016 PHPOffice Common contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace lib\phpoffice\common\src\Common\Tests;

use lib\phpoffice\common\src\Common\Text;

class TextTest extends \PHPUnit\Framework\TestCase
{
    /**
     */
    public function testControlCharacters()
    {
        $this->assertEquals('', Text::controlCharacterPHP2OOXML());
        $this->assertEquals('aeiou', Text::controlCharacterPHP2OOXML('aeiou'));
        $this->assertEquals('àéîöù', Text::controlCharacterPHP2OOXML('àéîöù'));

        $value = rand(0, 8);
        $this->assertEquals('_x'.sprintf('%04s', strtoupper(dechex($value))).'_', Text::controlCharacterPHP2OOXML(chr($value)));

        $this->assertEquals('', Text::controlCharacterOOXML2PHP(''));
        $this->assertEquals(chr(0x08), Text::controlCharacterOOXML2PHP('_x0008_'));
    }

    public function testNumberFormat()
    {
        $this->assertEquals('2.1', Text::numberFormat('2.06', 1));
        $this->assertEquals('2.1', Text::numberFormat('2.12', 1));
        $this->assertEquals('1234.0', Text::numberFormat(1234, 1));
    }

    public function testChr()
    {
        $this->assertEquals('A', Text::chr(65));
        $this->assertEquals('A', Text::chr(0x41));
        $this->assertEquals('é', Text::chr(233));
        $this->assertEquals('é', Text::chr(0xE9));
        $this->assertEquals('⼳', Text::chr(12083));
        $this->assertEquals('⼳', Text::chr(0x2F33));
        $this->assertEquals('🌃', Text::chr(127747));
        $this->assertEquals('🌃', Text::chr(0x1F303));
        $this->assertEquals('', Text::chr(2097152));
    }
    /**
     * Is UTF8
     */
    public function testIsUTF8()
    {
        $this->assertTrue(Text::isUTF8(''));
        $this->assertTrue(Text::isUTF8('éééé'));
        $this->assertFalse(Text::isUTF8(utf8_decode('éééé')));
    }

    /**
     * Test unicode conversion
     */
    public function testToUnicode()
    {
        $this->assertEquals('a', Text::toUnicode('a'));
        $this->assertEquals('\uc0{\u8364}', Text::toUnicode('€'));
        $this->assertEquals('\uc0{\u233}', Text::toUnicode('é'));
    }

    /**
     * Test remove underscore prefix
     */
    public function testRemoveUnderscorePrefix()
    {
        $this->assertEquals('item', Text::removeUnderscorePrefix('_item'));
    }
}
