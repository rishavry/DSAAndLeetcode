<?php


// to run this file, use this command: php PHP/CountingSort.php
class CountingSort {
    public function sortElementsFromStart(string $sortType, array $elementsToSort, int $min, int $max): array {
        $numbersAndTheirCounts = [];

        foreach ($elementsToSort as $element) {
            if (!isset($numbersAndTheirCounts[$element])) {
                $numbersAndTheirCounts[$element] = 0;
            }

            $numbersAndTheirCounts[$element]++;
        }

        $currVal = 0;

        if ($sortType === 'ascending') {
            for ($i=$min; $i<=$max; $i++) {
                if (isset($numbersAndTheirCounts[$i])) {
                    $numbersAndTheirCounts[$i] = $currVal;
                    $currVal+= $numbersAndTheirCounts[$i];
                }
            }
        }
        else {
            for ($i=$max; $i>=$min; $i--) {
                if (isset($numbersAndTheirCounts[$i])) {
                    $numbersAndTheirCounts[$i] = $currVal;
                    $currVal+= $numbersAndTheirCounts[$i];
                }
            }
        }

        $sortedElements = [];

        for ($i=0; $i<$currVal; $i++) {
            $currElement = $elementsToSort[$i];

            $sortedElements[$numbersAndTheirCounts[$currElement]] = $currElement;
            $numbersAndTheirCounts[$currElement]++;
        }

        return $sortedElements;
    }


    public function sortElementsFromEnd(string $sortType, array $elementsToSort, int $min, int $max): array {
        $numbersAndTheirCounts = [];

        foreach ($elementsToSort as $element) {
            if (!isset($numbersAndTheirCounts[$element])) {
                $numbersAndTheirCounts[$element] = 0;
            }

            $numbersAndTheirCounts[$element]++;
        }

        $currVal = 0;

        if ($sortType === 'ascending') {
            for ($i=$min; $i<=$max; $i++) {
                if (isset($numbersAndTheirCounts[$i])) {
                    $currVal+= $numbersAndTheirCounts[$i];
                    $numbersAndTheirCounts[$i] = $currVal;
                }
            }
        }
        else {
            for ($i=$max; $i>=$min; $i--) {
                if (isset($numbersAndTheirCounts[$i])) {
                    $currVal+= $numbersAndTheirCounts[$i];
                    $numbersAndTheirCounts[$i] = $currVal;
                }
            }
        }

        $sortedElements = [];

        for ($i=$currVal; $i>=0; $i--) {
            $currElement = $elementsToSort[$i];

            $sortedElements[$numbersAndTheirCounts[$currElement] - 1] = $currElement;
            $numbersAndTheirCounts[$currElement]--;
        }

        return $sortedElements;
    }
}