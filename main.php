<?php
require('Sentence.php');
require('DiffComporator.php');
require('TextParser.php');
require('TextRenderer.php');

$text = $argv[1];
$diff = $argv[2];

$parser = new TextParser();
$c = new DiffComporator($parser->getSentences($text), $parser->getSentences($diff));
var_dump($c->getSentences());
