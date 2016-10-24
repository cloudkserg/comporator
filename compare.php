<?php
require('Sentence.php');
require('DiffComporator.php');
require('TextParser.php');
require('TextRenderer.php');

if (!isset($_POST['originText']) or !isset($_POST['diffText'])) {
    echo 'not set texts in params';
    return;
}
$text = $_POST['originText']; $diff = $_POST['diffText'];

$parser = new TextParser();
$c = new DiffComporator($parser->getSentences($text), $parser->getSentences($diff));
echo (new TextRenderer($c->getSentences()))->getText();
return;
