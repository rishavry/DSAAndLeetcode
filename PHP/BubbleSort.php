<?php


// to run this file, use this command: php PHP/BubbleSort.php
class BubbleSort {
    public function sortElementsFromStart(string $sortType, array $elementsToSort): array {
        if ($sortType === 'ascending') {
            for($j=count($elementsToSort)-1; $j>=1; $j--) {
                for ($i=0; $i<$j; $i++) {
                    $currElement = $elementsToSort[$i];
                    $nextElement = $elementsToSort[$i+1];
    
                    if ($currElement > $nextElement) {
                        $elementsToSort[$i] = $nextElement;
                        $elementsToSort[$i+1] = $currElement;
                    }
                }
            }
        }
        else {
            for($j=count($elementsToSort)-1; $j>=1; $j--) {
                for ($i=0; $i<$j; $i++) {
                    $currElement = $elementsToSort[$i];
                    $nextElement = $elementsToSort[$i+1];
    
                    if ($currElement < $nextElement) {
                        $elementsToSort[$i] = $nextElement;
                        $elementsToSort[$i+1] = $currElement;
                    }
                }
            }
        }
        
        return $elementsToSort;
    }


    public function sortElementsFromEnd(string $sortType, array $elementsToSort): array {
        $numElementsToSort = count($elementsToSort);

        if ($sortType === 'ascending') {
            for($j=0; $j<=$numElementsToSort-2; $j++) {
                for ($i=$numElementsToSort-1; $i>$j; $i--) {
                    $currElement = $elementsToSort[$i];
                    $prevElement = $elementsToSort[$i-1];
    
                    if ($currElement < $prevElement) {
                        $elementsToSort[$i] = $prevElement;
                        $elementsToSort[$i-1] = $currElement;
                    }
                }
            }
        }
        else {
            for($j=0; $j<=$numElementsToSort-2; $j++) {
                for ($i=$numElementsToSort-1; $i>$j; $i--) {
                    $currElement = $elementsToSort[$i];
                    $prevElement = $elementsToSort[$i-1];
    
                    if ($currElement > $prevElement) {
                        $elementsToSort[$i] = $prevElement;
                        $elementsToSort[$i-1] = $currElement;
                    }
                }
            }
        }

        return $elementsToSort;
    }
}