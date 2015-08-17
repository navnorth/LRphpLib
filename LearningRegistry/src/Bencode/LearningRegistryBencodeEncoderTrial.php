<?PHP
/**
 * Rych Bencode Component
 *
 * @package   Rych\Bencode
 * @author    Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2014, Ryan Chouinard
 * @license   MIT License - http://www.opensource.org/licenses/mit-license.php
 */

/**
 * Bencode encoder
 *
 * @package   Rych\Bencode
 * @author    Ryan Chouinard <rchouinard@gmail.com>
 * @copyright Copyright (c) 2014, Ryan Chouinard
 * @license   MIT License - http://www.opensource.org/licenses/mit-license.php
 */
 
namespace LearningRegistry\Bencode;

class LearningRegistryBencodeEncoderTrial
{

    public function encode($value)
    {
        $type = gettype($value);
        $out  = '';

        switch($type)
        {
            case 'integer':
                $out.= 'i' . $value . 'e';
                break;
            case 'string':
                $out.= strlen($value) . ':' . utf8_encode($value);
                break;
            case 'array':
                if (!$this->is_associative($value)) {
                    $out.= 'l';
                    foreach ($value as $entry) {
                        $out.= $this->encode($entry);
                    }
                    $out.= 'e';
                } else {
                    $out.= 'd';
                    ksort($value);
                    foreach ($value as $key => $entry) {
                        $out.= $this->encode($key) . $this->encode($entry);
                    }
                    $out.= 'e';
                }
                break;
            case 'NULL':
                $out .= $this->encode((string)'NULL');
                break;
            case 'boolean':
                $out .= $this->encode((string) $value);
                break;
            default:
                break;
        }

        return $out;
    }

    /**
     * Decode $value to php types
     *
     * @access public
     * @param  string $value
     * @return integer|string|array
     */
    public function decode($value)
    {
        list($v, $r) = $this->rec_decode($value);

        return $v;
    }

    private function rec_decode($value)
    {
        switch($value[0])
        {
            # list
            case 'l':

                $value = substr($value, 1, -1);
                $out   = array();

                while (!empty($value)) {
                    list($v, $r) = $this->rec_decode($value);

                    $value = $r;

                    if (!empty($v)) {
                        $out[] = $v;
                    }
                }

                return array($out, false);

                break;

            # dictonary
            case 'd':

                $value = substr($value, 1, -1);
                $out   = array();

                while (!empty($value)) {
                    list($k, $r) = $this->rec_decode($value);

                    $value = $r;

                    list($v, $r) = $this->rec_decode($value);

                    $value = $r;

                    if (!empty($k) && !empty($v)) {
                        $out[$k] = $v;
                    }
                }

                return array($out, false);

                break;

            # integer
            case 'i':

                return $this->decode_int($value);

                break;

            # string
            case '0':
            case '1':
            case '2':
            case '3':
            case '4':
            case '5':
            case '6':
            case '7':
            case '8':
            case '9':

                return $this->decode_str($value);

                break;

            default:

                return false;
        }
    }

    private function decode_int($value)
    {
        if (isset($value[0]) && $value[0] == 'i') {
            $i      = 1;
            $length = '';

            while ($value[$i] != 'e') {
                $length.= $value[$i];

                $i++;
            }

            $result = intval($length);
            $value  = substr($value, strlen($length) + 2);

            return array($result, $value);
        }

        return array(false, false);
    }

    private function decode_str($value)
    {
        if (is_numeric($value[0])) {
            $i      = 0;
            $length = '';

            while ($value[$i] != ':') {
                $length.= $value[$i];

                $i++;
            }

            $length = intval($length);
            $result = substr($value, $i + 1, $length);
            $value  = substr($value, strlen($length) + 1 + $length);

            return array($result, $value);
        }

        return array(false, false);
    }

    private function is_associative($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            if (!isset($array[$i])) {
                return true;
            }
        }

        return false;
    }
}
