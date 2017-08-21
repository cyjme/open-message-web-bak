<?php
namespace Gap\Markdown;

// https://github.com/stiang/remove-markdown/blob/master/index.js
// http://parsedown.org/

class ExtractText
{
    public function text($input)
    {
        $out = preg_replace(
            [
                '/<(.*?)>/',
                '/[=\-]{2,}\s*\n/',
                '/\[\^.+?\](\: .*?$)?/',
                '/\s{0,2}\[.*?\]: .*?$/',
                '/\!\[.*?\][\[\(].*?[\]\)]/', // remove images
                '/>/',
                '/^\s{1,2}\[(.*?)\]: (\S+)( ".*?")?\s*$/',
                '/^-{3,}\s*$/',
                '/`{3}.*\n/',
                '/~~/',
            ],
            '',
            $input
        );

        $out = preg_replace(
            [
                '/\n{2,}/',
                '/\[(.*?)\][\[\(].*?[\]\)]/',
                "/\#{1,6}\s*([^#]*)\s*(\#{1,6})?\n/",
                '/([\*_]{1,3})(\S.*?\S)\1/',
                '/(`{3,})(.*?)\1/',
                '/`(.+?)`/',
            ],
            [
                "\n",
                '$1',
                '$1',
                '$2',
                '$2',
                '$1'
            ],
            $out
        );

        $out = preg_replace("/[\n\r]/", ' ', $out);

        return $out;
    }

    public function abbr($input, $min, $max)
    {
        $out = preg_replace(
            "~^\#\s*([^#\n]*)(\s*\#)?\n~",
            '',
            $input
        );

        $out = substr($this->text($out), 0, $max);
        $matched = preg_match(
            "~[,|.|;|\s|\'|\"|，|。|；|“|‘]~",
            $out,
            $matches,
            PREG_OFFSET_CAPTURE,
            $min
        );

        if ($matched) {
            return substr($out, 0, $matches[0][1]);
        }

        return $out;
    }

    public function title($input)
    {
        $matched = preg_match(
            "~^\#\s*([^#\n]*)(\s*\#)?\n~",
            $input,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        if ($matched) {
            return $matches[1][0];
        }
    }
}
