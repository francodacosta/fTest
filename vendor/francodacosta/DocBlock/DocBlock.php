<?php
namespace francodacosta\DocBlock;

class DocBlock
{
    private $comment;
    private $description;
    private $tags = array();

    public function __construct($comment)
    {
        if (!is_string($comment)) {
            throw new \UnexpectedValueException("Comment must be a string");
        }

        $this->parse($comment);
    }

    private function parseTags(array $tags)
    {
        $ret = array();
        foreach($tags as $tag) {
            list($tagName, $tagValue) = @explode(' ', $tag, 2);

            $tagName = ltrim('@', $tagName);
            if(!array_key_exists($tagName, $ret)) {
                $ret[$tagName] = array();
            }
            $ret[$tagName][] = $tagValue;
        }

        return $ret;
    }
    public function parse($comment)
    {
        if (!is_string($comment)) {
            throw new \UnexpectedValueException("Comment must be a string");
        }

         // remove start and end tags
        $comment = ltrim(rtrim($comment, '*/'), '/**');

        // normalize line endings and remove initial * from line
        $commentLines = preg_split('/\r?\n\r?/', $comment);
        $desc = '';
        $tags = array();
        foreach($commentLines as $line) {
            $normalLine = preg_replace('/^.*\*/', '', $line);

            // is this a tag
            if (1 == preg_match('/@.* /', $normalLine)) {
                $tags[] = $normalLine;
            } else {
                $desc .= $normalLine . "\n";
            }
        }
        $this->tags = $this->parseTags($tags);
        $this->comment = $desc;
        return $comment;
    }

    public function getShortDescription()
    {
        $comment = $this->comment;
        $matches = array();

        if(1 == preg_match('/.*\.[ \n \t]|.*\n\n/', $comment, $matches)) {
            return $matches[0];
        }else {
            return null;
        }
    }

    public function getLongDescription()
    {
        $short = $this->getShortDescription();
        $ret = substr($this->comment, strlen($short) + 1);

        return $ret;
    }

    public function hasTag($name) {
        return array_key_exists($name, $this->tags);
    }

    public function getTag($name)
    {
        return $this->hasTag($name) ? $this->tags[$name] : null;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
