<?php
namespace phpunit\Gap\Markdown;

use Gap\Markdown\ExtractText;

class ExtractTextTest extends \PHPUnit_Framework_TestCase
{
    public function testText()
    {
        $extra = new ExtractText();

        $this->assertEquals('text a', $extra->text('<div>text</div> <span>a</span>'));
        $this->assertEquals("a", $extra->text("==  \n--\na"));
        $this->assertEquals($extra->text("# test #d\n\n\na"), 'test d a');
    }
}
