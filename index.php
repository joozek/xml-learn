<?php

require_once 'data/books.php';

function createDOMElementWithContent(string $elName, string $content): \DOMElement
{
    $elDOM = new DOMElement($elName);
    $elDOM->textContent = $content;

    return $elDOM;
}

$doc = new DOMDocument('1.0', 'UTF-8');
$rootEl = new DOMElement('library');
$root = $doc->appendChild($rootEl);
$booksEl = new DOMElement('books');
$books = $root->appendChild($booksEl);
$books->setAttribute('country', 'England');
$books->setAttribute('city', 'London');
$books->setAttribute('name', 'The London Library');

foreach ($data as $b) {
    $bookEl = new DOMElement('book');
    $book = $books->appendChild($bookEl);

    $book->setAttribute('id', $b['id']);
    $book->setAttribute('type', $b['type']);
    $book->setAttribute('price', $b['price']);

    $title = createDOMElementWithContent('title', $b['title']);
    $desc = createDOMElementWithContent('desc', $b['desc']);
    $author = createDOMElementWithContent('author', $b['author']);

    $book->appendChild($title);
    $book->appendChild($desc);
    $book->appendChild($author);

    $quotesEl = new DOMElement('quotes');
    $quotes = $book->appendChild($quotesEl);

    foreach ($b['quotes'] as $key => $q) {
        $qType = $key;
        foreach ($q as $qContent) {
            $quote = createDOMElementWithContent('quote', $qContent);
            $quotes->appendChild($quote);
            $quote->setAttribute('type', $qType);
        };
    }

    $heroesEl = new DOMElement('heroes');
    $heroes = $book->appendChild($heroesEl);

    foreach ($b['heroes'] as $h) {
        $hero = createDOMElementWithContent('name', $h['name']);
        $heroes->appendChild($hero);
    }

    $books->appendChild($bookEl);
}

echo $doc->saveXML();
