<?php
/**
 * Html2Pdf Library - Tests
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2017 Laurent MINGUET
 */

namespace Spipu\Html2Pdf\Tests\Tag;

use Spipu\Html2Pdf\Html2Pdf;

/**
 * Class TdTooLongTest
 */
class TdTooLongTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test
     *
     * @return void
     * @expectedException \Spipu\Html2Pdf\Exception\TableException
     */
    public function testCase()
    {
        $sentence = 'Hello World ! ';
        $sentences = '';
        for ($k = 0; $k < 100; $k++) {
            $sentences .= $sentence;
        }

        $object = new Html2Pdf();
        $object->pdf->SetTitle('PhpUnit Test');
        $object->writeHTML('<table><tr><td style="width: 28mm">' . $sentences . '</td></tr></table>');
        $object->Output('test.pdf', 'S');
    }
}
