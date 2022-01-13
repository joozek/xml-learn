<?php

function createDOMElementWithContent(string $elName, string $content): \DOMElement
{
    $node = new DOMElement($elName);
    $node->textContent = $content;

    return $node;
}

function generateLibraryFromBooksData(array $data): void
{
    $doc = new DOMDocument('1.0', 'UTF-8');
    $rootNode = new DOMElement('Library');
    $root = $doc->appendChild($rootNode);
    $root->setAttribute('Name', 'The London Library');
    $root->setAttribute('City', 'London');
    $root->setAttribute('Country', 'England');
    $booksNode = new DOMElement('Books');
    $books = $root->appendChild($booksNode);

    foreach ($data as $b) {
        $bookNode = new DOMElement('Book');
        $book = $books->appendChild($bookNode);

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

        $quotesNode = new DOMElement('Quotes');
        $quotes = $book->appendChild($quotesNode);

        foreach ($b['quotes'] as $key => $q) {
            $qType = $key;
            foreach ($q as $qContent) {
                $quote = createDOMElementWithContent('Quote', $qContent);
                $quotes->appendChild($quote);
                $quote->setAttribute('Type', $qType);
            };
        }

        $heroesNode = new DOMElement('Heroes');
        $heroes = $book->appendChild($heroesNode);

        foreach ($b['heroes'] as $h) {
            $hero = new DOMElement('Hero');
            $heroes->appendChild($hero);
            $desc = createDOMElementWithContent('Desc', $h['desc']);
            $hero->setAttribute('Name', $h['name']);
            $hero->appendChild($desc);
        }

        $books->appendChild($bookNode);
    }

    echo $doc->saveXML();
}
