<?php
namespace lib;
use lib\QRspec;
use lib\QRencode;
use lib\QRrawcode;
use lib\QRtools;
use lib\QRmask;
use lib\QRinput;
use lib\QRsplit;

// Encoding modes
 
define('QR_MODE_NUL', -1);
define('QR_MODE_NUM', 0);
define('QR_MODE_AN', 1);
define('QR_MODE_8', 2);
define('QR_MODE_KANJI', 3);
define('QR_MODE_STRUCTURE', 4);

// Levels of error correction.

define('QR_ECLEVEL_L', 0);
define('QR_ECLEVEL_M', 1);
define('QR_ECLEVEL_Q', 2);
define('QR_ECLEVEL_H', 3);

// Supported output formats

define('QR_FORMAT_TEXT', 0);
define('QR_FORMAT_PNG',  1);

/*
 * PHP QR Code encoder
 *
 * Config file, tuned-up for merged verion
 */
     
define('QR_CACHEABLE', false);       // use cache - more disk reads but less CPU power, masks and format templates are stored there
define('QR_CACHE_DIR', false);       // used when QR_CACHEABLE === true
define('QR_LOG_DIR', false);         // default error logs dir   

define('QR_FIND_BEST_MASK', true);                                                          // if true, estimates best mask (spec. default, but extremally slow; set to false to significant performance boost but (propably) worst quality code
define('QR_FIND_FROM_RANDOM', 2);                                                       // if false, checks all masks available, otherwise value tells count of masks need to be checked, mask id are got randomly
define('QR_DEFAULT_MASK', 2);                                                               // when QR_FIND_BEST_MASK === false
                                              
define('QR_PNG_MAXIMUM_SIZE',  1024);                                                       // maximum allowed png image width (in pixels), tune to make sure GD and PHP can handle such big images



if (!defined('QRCODEDEFS')) {

	/**
	 * Indicate that definitions for this class are set
	 */
	define('QRCODEDEFS', true);

	// -----------------------------------------------------

	// Encoding modes (characters which can be encoded in QRcode)

	/**
	 * Encoding mode
	 */
	define('QR_MODE_NL', -1);

	/**
	 * Encoding mode numeric (0-9). 3 characters are encoded to 10bit length. In theory, 7089 characters or less can be stored in a QRcode.
	 */
	define('QR_MODE_NM', 0);

	/**
	 * Encoding mode alphanumeric (0-9A-Z $%*+-./:) 45characters. 2 characters are encoded to 11bit length. In theory, 4296 characters or less can be stored in a QRcode.
	 */
	define('QR_MODE_AN', 1);

	/**
	 * Encoding mode 8bit byte data. In theory, 2953 characters or less can be stored in a QRcode.
	 */
	define('QR_MODE_8B', 2);

	/**
	 * Encoding mode KANJI. A KANJI character (multibyte character) is encoded to 13bit length. In theory, 1817 characters or less can be stored in a QRcode.
	 */
	define('QR_MODE_KJ', 3);

	/**
	 * Encoding mode STRUCTURED (currently unsupported)
	 */
	define('QR_MODE_ST', 4);

	// -----------------------------------------------------

	// Levels of error correction.
	// QRcode has a function of an error correcting for miss reading that white is black.
	// Error correcting is defined in 4 level as below.

	/**
	 * Error correction level L : About 7% or less errors can be corrected.
	 */
	define('QR_ECLEVEL_L', 0);

	/**
	 * Error correction level M : About 15% or less errors can be corrected.
	 */
	define('QR_ECLEVEL_M', 1);

	/**
	 * Error correction level Q : About 25% or less errors can be corrected.
	 */
	define('QR_ECLEVEL_Q', 2);

	/**
	 * Error correction level H : About 30% or less errors can be corrected.
	 */
	define('QR_ECLEVEL_H', 3);

	// -----------------------------------------------------

	// Version. Size of QRcode is defined as version.
	// Version is from 1 to 40.
	// Version 1 is 21*21 matrix. And 4 modules increases whenever 1 version increases.
	// So version 40 is 177*177 matrix.

	/**
	 * Maximum QR Code version.
	 */
	define('QRSPEC_VERSION_MAX', 40);

	/**
	 * Maximum matrix size for maximum version (version 40 is 177*177 matrix).
	 */
    define('QRSPEC_WIDTH_MAX', 177);

	// -----------------------------------------------------

	/**
	 * Matrix index to get width from $capacity array.
	 */
    define('QRCAP_WIDTH',    0);

    /**
	 * Matrix index to get number of words from $capacity array.
	 */
    define('QRCAP_WORDS',    1);

    /**
	 * Matrix index to get remainder from $capacity array.
	 */
    define('QRCAP_REMINDER', 2);

    /**
	 * Matrix index to get error correction level from $capacity array.
	 */
    define('QRCAP_EC',       3);

	// -----------------------------------------------------

	// Structure (currently usupported)

	/**
	 * Number of header bits for structured mode
	 */
    define('STRUCTURE_HEADER_BITS',  20);

    /**
	 * Max number of symbols for structured mode
	 */
    define('MAX_STRUCTURED_SYMBOLS', 16);

	// -----------------------------------------------------

    // Masks

    /**
	 * Down point base value for case 1 mask pattern (concatenation of same color in a line or a column)
	 */
    define('N1',  3);

    /**
	 * Down point base value for case 2 mask pattern (module block of same color)
	 */
	define('N2',  3);

    /**
	 * Down point base value for case 3 mask pattern (1:1:3:1:1(dark:bright:dark:bright:dark)pattern in a line or a column)
	 */
	define('N3', 40);

    /**
	 * Down point base value for case 4 mask pattern (ration of dark modules in whole)
	 */
	define('N4', 10);

	// -----------------------------------------------------

	// Optimization settings

	/**
	 * if true, estimates best mask (spec. default, but extremally slow; set to false to significant performance boost but (propably) worst quality code
	 */
	define('QR_FIND_BEST_MASK', true);

	/**
	 * if false, checks all masks available, otherwise value tells count of masks need to be checked, mask id are got randomly
	 */
	define('QR_FIND_FROM_RANDOM', 2);

	/**
	 * when QR_FIND_BEST_MASK === false
	 */
	define('QR_DEFAULT_MASK', 2);

	// -----------------------------------------------------

} // end of definitions

    class QRcode {

        public $version;
        public $width;
        public $data;

        //----------------------------------------------------------------------
        public function encodeMask(QRinput $input, $mask)
        {
            if($input->getVersion() < 0 || $input->getVersion() > QRSPEC_VERSION_MAX) {
                throw new Exception('wrong version');
            }
            if($input->getErrorCorrectionLevel() > QR_ECLEVEL_H) {
                throw new Exception('wrong level');
            }

            $raw = new QRrawcode($input);

            QRtools::markTime('after_raw');

            $version = $raw->version;
            $width = QRspec::getWidth($version);
            $frame = QRspec::newFrame($version);

            $filler = new FrameFiller($width, $frame);
            if(is_null($filler)) {
                return NULL;
            }

            // inteleaved data and ecc codes
            for($i=0; $i<$raw->dataLength + $raw->eccLength; $i++) {
                $code = $raw->getCode();
                $bit = 0x80;
                for($j=0; $j<8; $j++) {
                    $addr = $filler->next();
                    $filler->setFrameAt($addr, 0x02 | (($bit & $code) != 0));
                    $bit = $bit >> 1;
                }
            }

            QRtools::markTime('after_filler');

            unset($raw);

            // remainder bits
            $j = QRspec::getRemainder($version);
            for($i=0; $i<$j; $i++) {
                $addr = $filler->next();
                $filler->setFrameAt($addr, 0x02);
            }

            $frame = $filler->frame;
            unset($filler);


            // masking
            $maskObj = new QRmask();
            if($mask < 0) {

                if (QR_FIND_BEST_MASK) {
                    $masked = $maskObj->mask($width, $frame, $input->getErrorCorrectionLevel());
                } else {
                    $masked = $maskObj->makeMask($width, $frame, (intval(QR_DEFAULT_MASK) % 8), $input->getErrorCorrectionLevel());
                }
            } else {
                $masked = $maskObj->makeMask($width, $frame, $mask, $input->getErrorCorrectionLevel());
            }

            if($masked == NULL) {
                return NULL;
            }

            QRtools::markTime('after_mask');

            $this->version = $version;
            $this->width = $width;
            $this->data = $masked;

            return $this;
        }

        //----------------------------------------------------------------------
        public function encodeInput(QRinput $input)
        {
            // var_dump(QRinput $input);
            return $this->encodeMask($input, -1);
        }

        //----------------------------------------------------------------------
        public function encodeString8bit($string, $version, $level)
        {
            if(string == NULL) {
                throw new Exception('empty string!');
                return NULL;
            }

            $input = new QRinput($version, $level);
            if($input == NULL) return NULL;
// 
            $ret = $input->append($input, QR_MODE_8, strlen($string), str_split($string));
            if($ret < 0) {
                unset($input);
                return NULL;
            }
            return $this->encodeInput($input);
        }

        //----------------------------------------------------------------------
        public function encodeString($string, $version, $level, $hint, $casesensitive)
        {

            if($hint != QR_MODE_8 && $hint != QR_MODE_KANJI) {
                throw new Exception('bad hint');
                return NULL;
            }

            $input = new QRinput($version, $level);
            if($input == NULL) return NULL;

            $ret = QRsplit::splitStringToQRinput($string, $input, $hint, $casesensitive);
            if($ret < 0) {
                return NULL;
            }
            return $this->encodeInput($input);
        }

        //----------------------------------------------------------------------
        public static function png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false)
        {
            $enc = QRencode::factory($level, $size, $margin);
            return $enc->encodePNG($text, $outfile, $saveandprint=false);
        }

        //----------------------------------------------------------------------
        public static function text($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4)
        {
            $enc = QRencode::factory($level, $size, $margin);
            return $enc->encode($text, $outfile);
        }

        //----------------------------------------------------------------------
        public static function raw($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4)
        {
            $enc = QRencode::factory($level, $size, $margin);
            return $enc->encodeRAW($text, $outfile);
        }
    }
?>
