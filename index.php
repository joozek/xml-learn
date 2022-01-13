<?php

require_once 'data/books.php';

function createDOMElementWithContent(string $elName, string $content): \DOMElement
{
    $elDOM = new DOMElement($elName);
    $elDOM->textContent = $content;

    return $elDOM;
}

$doc = new DOMDocument('1.0', 'UTF-8');
$rootEl = new DOMElement('Library');
$root = $doc->appendChild($rootEl);
$booksEl = new DOMElement('Books');
$books = $root->appendChild($booksEl);
$books->setAttribute('Country', 'England');
$books->setAttribute('City', 'London');
$books->setAttribute('Name', 'The London Library');

foreach ($data as $b) {
    $bookEl = new DOMElement('Book');
    $book = $books->appendChild($bookEl);

    $written = $b['written'];

    $book->setAttribute('ID', $b['id']);
    $book->setAttribute('Type', $b['type']);
    $book->setAttribute('Price', $b['price']);
    $book->setAttribute('Lang', $b['lang']);
    $book->setAttribute('Written_Time', $written['time']);
    $book->setAttribute('Written_Place', $written['place']);

    $title = createDOMElementWithContent('Title', $b['title']);
    $desc = createDOMElementWithContent('Description', $b['desc']);
    $author = createDOMElementWithContent('Author', $b['author']);
    $genre = createDOMElementWithContent('Genre', $b['genre']);
    $publication = createDOMElementWithContent('Publication', 'In ' . $b['publication'] . ' by ' . $b['publisher']);

    $book->appendChild($title);
    $book->appendChild($desc);
    $book->appendChild($author);
    $book->appendChild($genre);
    $book->appendChild($publication);

    $quotesEl = new DOMElement('Quotes');
    $quotes = $book->appendChild($quotesEl);

    foreach ($b['quotes'] as $key => $q) {
        $qType = $key;
        foreach ($q as $qContent) {
            $quote = createDOMElementWithContent('Quote', $qContent);
            $quotes->appendChild($quote);
            $quote->setAttribute('Type', $qType);
        };
    }

    $heroesEl = new DOMElement('Heroes');
    $heroes = $book->appendChild($heroesEl);

    foreach ($b['heroes'] as $h) {
        $hero = createDOMElementWithContent('Name', $h['name']);
        $heroes->appendChild($hero);
    }

    $books->appendChild($bookEl);
}

echo $doc->saveXML();
