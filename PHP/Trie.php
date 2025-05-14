<?php


// to run this file, use this command: php PHP/Trie.php
class TrieNode {
    public string $char;

    public array $children;


    public function __construct(string $char) {
        $this->char = $char;
    }
}


class Trie {
    private TrieNode $root;

    private int $numWords;
    private int $numNodes;


    public function __construct() {
        $this->root = new TrieNode('');
    }


    public function getRoot(): TrieNode {
        return $this->root;
    }


    public function getNumWords(): int {
        return $this->numWords;
    }


    public function getNumNodes(): int {
        return $this->numNodes;
    }


    public function searchForWord(string $word): bool {
        $currNode = $this->root;
        $currIndex = 0;

        while ($currIndex <= strlen($word)) {
            $letterOfNextCurrNode = $currIndex < strlen($word) ? $word[$currIndex] : '/';
            $nextCurrNode = null;

            foreach($currNode->children as $currNodeChild) {
                if ($currNodeChild->char == $letterOfNextCurrNode) {
                    $nextCurrNode = $currNodeChild;
                    break;
                }
            }

            if ($nextCurrNode == null) {
               return false;
            }

            $currIndex++;
            $currNode = $nextCurrNode;
        }

        return true;
    }


    public function insertWord(string $word): bool {
        $currNode = $this->root;
        $currIndex = 0;
        $wordIsNew = false;

        while ($currIndex <= strlen($word)) {
            $letterOfNextCurrNode = $currIndex < strlen($word) ? $word[$currIndex] : '/';
            $nextCurrNode = null;

            foreach($currNode->children as $currNodeChild) {
                if ($currNodeChild->char == $letterOfNextCurrNode) {
                    $nextCurrNode = $currNodeChild;
                    break;
                }
            }

            if ($nextCurrNode == null) {
                $wordIsNew = true;
                $newChildNode = new TrieNode($letterOfNextCurrNode);
                $currNode->children[] = $newChildNode;
                $this->numNodes++;
                $nextCurrNode = $newChildNode;
            }

            $currIndex++;
            $currNode = $nextCurrNode;
        }

        if ($wordIsNew) {
            $this->numWords++;
        }

        return $wordIsNew;
    }


    public function deleteWord(string $word): bool {
        $currNode = $this->root;
        $currIndex = 0;

        while ($currIndex < strlen($word)) {
            $letterOfNextCurrNode = $word[$currIndex];
            $nextCurrNode = null;

            foreach($currNode->children as $currNodeChild) {
                if ($currNodeChild->char == $letterOfNextCurrNode) {
                    $nextCurrNode = $currNodeChild;
                    break;
                }
            }

            if ($nextCurrNode == null) {
                return false;
            }

            $currIndex++;
            $currNode = $nextCurrNode;
        }

        for($i=0; $i < count($currNode->children); $i++) {
            $currNodeChild = $currNode->children[$i];
            
            if ($currNodeChild->char == '/') {
                array_splice($currNode->children, $i, 1);
                $this->numNodes--;
                $this->numWords--;
                return true;
            }
        }

        return false;
    }


    public function getAllWordsInSpecifiedOrder(string $prefix, string $order) {
        $currNode = $this->root;
        $currIndex = 0;

        while ($currIndex < strlen($prefix)) {
            $letterOfNextCurrNode = $prefix[$currIndex];
            $nextCurrNode = null;

            foreach($currNode->children as $currNodeChild) {
                if ($currNodeChild->char == $letterOfNextCurrNode) {
                    $nextCurrNode = $currNodeChild;
                    break;
                }
            }

            if ($nextCurrNode == null) {
               return [];
            }

            $currIndex++;
            $currNode = $nextCurrNode;
        }

        if ($order === 'none') {
            return $this->recursiveHelperForGettingWordsInNoSpecifiedOrder($prefix, $currNode);
        }
        else if ($order === 'alphabetical') {
            return $this->recursiveHelperForGettingWordsInAlphabeticalOrder($prefix, $currNode);
        }
        else if ($order === 'reverse-alphabetical') {
            return $this->recursiveHelperForGettingWordsInReverseAlphabeticalOrder($prefix, $currNode);
        }
        return [];
    }

    
    private function recursiveHelperForGettingWordsInNoSpecifiedOrder(string $currString, TrieNode $currNode): array {
        $words = [];

        foreach($currNode->children as $currNodeChild) {
            $currNodeChildChar = $currNodeChild->char;

            if ($currNodeChildChar === '/') {
                $words[] = $currString;
            }
            else {
                array_merge($words, $this->recursiveHelperForGettingWordsInNoSpecifiedOrder(
                    $currString + $currNodeChildChar,
                    $currNodeChild
                ));
            }
        }

        return $words;
    }


    private function recursiveHelperForGettingWordsInAlphabeticalOrder(string $currString, TrieNode $currNode): array {
        $words = [];
        $currStringIsWord = false;

        $alphabeticallySortedCurrNodeChildren = $currNode->children;
        sort($alphabeticallySortedCurrNodeChildren);

        foreach($alphabeticallySortedCurrNodeChildren as $currNodeChild) {
            $currNodeChildChar = $currNodeChild->char;

            if ($currNodeChildChar === '/') {
                $currStringIsWord = true;
            }
            else {
                array_merge($words, $this->recursiveHelperForGettingWordsInAlphabeticalOrder(
                    $currString + $currNodeChildChar,
                    $currNodeChild
                ));
            }
        }

        if ($currStringIsWord) {
            $words = array_merge([0], $words);
        }

        return $words;
    }


    private function recursiveHelperForGettingWordsInReverseAlphabeticalOrder(string $currString, TrieNode $currNode): array {
        $words = [];
        $currStringIsWord = false;

        $reverseAlphabeticallySortedCurrNodeChildren = $currNode->children;
        rsort($reverseAlphabeticallySortedCurrNodeChildren);

        foreach($reverseAlphabeticallySortedCurrNodeChildren as $currNodeChild) {
            $currNodeChildChar = $currNodeChild->char;
            
            if ($currNodeChildChar === '/') {
                $currStringIsWord = true;
            }
            else {
                array_merge($words, $this->recursiveHelperForGettingWordsInReverseAlphabeticalOrder(
                    $currString + $currNodeChildChar,
                    $currNodeChild
                ));
            }
        }

        if ($currStringIsWord) {
            $words[] = $currString;
        }

        return $words;
    }


    public function getAutocompleteSuggestions(string $prefix, string $letterAfterPrefixToExclude, int $numSuggestions): array {
        if($numSuggestions == 0) {
            return [];
        }

        $currNode = $this->root;
        $currIndex = 0;

        while ($currIndex < strlen($prefix)) {
            $letterOfNextCurrNode = $prefix[$currIndex];
            $nextCurrNode = null;

            foreach($currNode->children as $currNodeChild) {
                if ($currNodeChild->char == $letterOfNextCurrNode) {
                    $nextCurrNode = $currNodeChild;
                    break;
                }
            }

            if ($nextCurrNode == null) {
               return [];
            }

            $currIndex++;
            $currNode = $nextCurrNode;
        }

        $numSuggestionsFound = 0;
        $autocompleteSuggestions = [];
        $queue = [[$prefix, $currNode]];
        $queueSize = 1;

        while ($queueSize > 0) {
            for($i=0; $i<$queueSize; $i++) {
                $currStringAndNode = $queue[0];
                $currString = $currStringAndNode[0];
                $currNode = $currStringAndNode[1];

                array_splice($queue, 0, 1);

                foreach($currNode->children as $currNodeChild) {
                    $currNodeChildChar = $currNodeChild->char;

                    if ($currNodeChildChar === $letterAfterPrefixToExclude) {
                        continue;
                    }

                    if ($currNodeChildChar === '/') {
                        $autocompleteSuggestions[] = $currString;
                        $numSuggestionsFound++;

                        if ($numSuggestionsFound == $numSuggestions) {
                            return $autocompleteSuggestions;
                        }
                    }
                    else {
                        $queue[] = [$currString + $currNodeChildChar, $currNodeChild];
                    }
                }
            }

            $queueSize = count($queue);
        }
 
        return $autocompleteSuggestions;
    }


    public function getAutocorrectSuggestions(string $word, int $numSuggestions): array {
        if($numSuggestions == 0) {
            return [];
        }

        $wordExists = $this->searchForWord($word);

        if ($wordExists) {
            return [];
        }

        $numSuggestionsFound = 0;
        $autocorrectSuggestions = [];
        $wordLength = strlen($word);

        for($i=0; $i<$wordLength; $i++) {
            $prefix = substr($word, 0, $wordLength - $i);

            $autocompleteSuggestionsForPrefix = $this->getAutocompleteSuggestions(
                $prefix,
                $i == 0 ? '' : substr($word, - $i, 1),
                $numSuggestions - $numSuggestionsFound
            );

            $autocorrectSuggestions = array_merge(
                $autocorrectSuggestions,
                $autocompleteSuggestionsForPrefix
            );

            $numSuggestionsFound += count($autocompleteSuggestionsForPrefix);

            if ($numSuggestionsFound == $numSuggestions) {
                return $autocorrectSuggestions;
            }
        }
 
        return $autocorrectSuggestions;
    }
}