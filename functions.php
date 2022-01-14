<?php

function createDOMElementWithContent(string $elName, string $content): \DOMElement
{

    $node = new DOMElement($elName);
    $node->textContent = $content;

    return $node;
}

function generateString(int $length): string
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str .= 'abcdefghijklmnopqrstuvwxyz';
    $str .= '0123456789';
    $str .= '!@#$%^&*()_+{}|:"<>?';

    $res = '';

    for ($i = 0; $i <= $length; $i++) {
        $randNumber = rand(0, strlen($str) - 1);
        $res .= $str[$randNumber];
    }

    return $res;
}

function generateLibraryFromBooksData(array $data): \DOMDocument
{
    $ns = '1546058f-5a25-4334-85ae-e68f2a44bbaf';

    $doc = new DOMDocument('1.0', 'UTF-8');
    $rootNode = new DOMELement('Library');
    $root = $doc->appendChild($rootNode);
    $root->setAttribute('uuid', UUID::v5($ns, generateString(10)));
    $root->setAttribute('Name', 'The London Library');
    $root->setAttribute('City', 'London');
    $root->setAttribute('Country', 'England');
    $booksNode = new DOMElement('Books');
    $books = $root->appendChild($booksNode);
    $books->setAttribute('uuid', UUID::v5($ns, generateString(10)));

    foreach ($data as $b) {
        $bookNode = $doc->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'Book');
        $book = $books->appendChild($bookNode);

        $written = $b['written'];

        $book->setAttribute('uuid', UUID::v5($ns, generateString(10)));
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

        $title->setAttribute('uuid', UUID::v5($ns, generateString(10)));
        $desc->setAttribute('uuid', UUID::v5($ns, generateString(10)));
        $author->setAttribute('uuid', UUID::v5($ns, generateString(10)));
        $genre->setAttribute('uuid', UUID::v5($ns, generateString(10)));
        $publication->setAttribute('uuid', UUID::v5($ns, generateString(10)));
        $quotesNode = new DOMElement('Quotes');

        $quotes = $book->appendChild($quotesNode);
        $quotes->setAttribute('uuid', UUID::v5($ns, generateString(10)));

        foreach ($b['quotes'] as $key => $q) {
            $qType = $key;
            foreach ($q as $qContent) {
                $quote = new DOMElement('Quote');
                $quotes->appendChild($quote);
                $quoteDesc = createDOMElementWithContent('Description', $qContent);
                $quote->appendChild($quoteDesc);
                $quoteDesc->setAttribute('uuid', UUID::v5($ns, generateString(10)));
                $quoteDesc->setAttribute('Type', $qType);
            };
        }

        $heroesNode = new DOMElement('Heroes');
        $heroes = $book->appendChild($heroesNode);
        $heroes->setAttribute('uuid', UUID::v5($ns, generateString(10)));


        foreach ($b['heroes'] as $h) {
            $hero = new DOMElement('Hero');
            $heroes->appendChild($hero);
            $desc = createDOMElementWithContent('Description', $h['desc']);
            $hero->setAttribute('uuid', UUID::v5($ns, generateString(10)));
            $hero->setAttribute('Name', $h['name']);
            $hero->appendChild($desc);
        }

        $books->appendChild($bookNode);
    }

    $doc->formatOutput = true;
    return $doc;
}
