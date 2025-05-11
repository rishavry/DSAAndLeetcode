<?php


// to run this file, use this command: php PHP/SkipList.php
class MultiLevelNode {
    public int $data;

    public MultiLevelNode $prev;
    public MultiLevelNode $next;
    public MultiLevelNode $above;
    public MultiLevelNode $below;


    public function __construct(int $data) {
        $this->data = $data;
    }
}


class SkipList {
    private MultiLevelNode $head;
    private int $numLevels = 0;


    public function getHead(): MultiLevelNode {
        return $this->head;
    }


    public function getNumLevels(): int {
        return $this->numLevels;
    }


    public function search(int $target): bool {
        $currNode = $this->head;

        if ($currNode == null || $currNode->data > $target) {
            return false;
        }

        while ($currNode !== null) {
            if ($currNode->data == $target) {
                return true;
            }
            
            if ($currNode->next == null || $currNode->next->data > $target) {
                $currNode = $currNode->below;
            }
            else {
                $currNode = $currNode->next;
            }
        }
        
        return false;
    }


    public function insert(int $value): void {
        $currNode = $this->head;
    
        if ($currNode === null) {
            $newHeadNode = new MultiLevelNode($value);
    
            $randomNumber = rand(1, 10);
            $currNode = $newHeadNode;
    
            while ($randomNumber <= 5) {
                $newMultilevelNode = new MultiLevelNode($value);
    
                $currNode->above = $newMultilevelNode;
                $newMultilevelNode->below = $currNode;
                $this->numLevels++;
    
                $currNode = $newMultilevelNode;
                $randomNumber = rand(1, 10);
            }
    
            $this->head = $currNode;
            return;
        }
    
        if ($value < $currNode->data) {
            $mostRecentlyAddedMultilevelNode = null;
    
            while ($currNode !== null) {
                $newMultilevelNode = new MultiLevelNode($value);
                $currNode->prev = $newMultilevelNode;
                $newMultilevelNode->next = $currNode;
    
                if ($mostRecentlyAddedMultilevelNode !== null) {
                    $mostRecentlyAddedMultilevelNode->below = $newMultilevelNode;
                    $newMultilevelNode->above = $mostRecentlyAddedMultilevelNode;
                }
                else {
                    $this->head = $newMultilevelNode;
                }
    
                $mostRecentlyAddedMultilevelNode = $newMultilevelNode;
                $currNode = $currNode->below;
            }
    
            return;
        }
    
        $nodesOfEachLevel = [];
    
        while ($currNode !== null) {
            if ($currNode->data == $value) {
                return;
            }
    
            if ($currNode->data < $value) {
                if ($currNode->next === null || $currNode->next->data > $value) {
                    $nodesOfEachLevel[] = $currNode;
                    $currNode = $currNode->below;
                }
                else {
                    $currNode = $currNode->next;
                }
            }
        }
    
        $nodesOfEachLevel = array_reverse($nodesOfEachLevel);
    
        $newMultilevelNode = new MultiLevelNode($value);
        $newMultilevelNode->prev = $nodesOfEachLevel[0];
        $newMultilevelNode->next = $nodesOfEachLevel[0]->next;
        $nodesOfEachLevel[0]->next = $newMultilevelNode;
    
        if ($newMultilevelNode->next !== null) {
            $newMultilevelNode->next->prev = $newMultilevelNode;
        }
    
        $i = 1;
        $randomNumber = rand(1, 10);
        $mostRecentlyAddedMultilevelNode = $newMultilevelNode;
        $mostRecentlyAddedHeadNode = null;
        $valueStoredInHead = $this->head->data;
    
        while ($randomNumber <= 5) {
            $newMultilevelNode = new MultiLevelNode($value);
    
            if ($i < count($nodesOfEachLevel)) {
                $newMultilevelNode->next = $nodesOfEachLevel[$i]->next;
                $newMultilevelNode->prev = $nodesOfEachLevel[$i];
                $nodesOfEachLevel[$i]->next = $newMultilevelNode;
    
                if ($newMultilevelNode->next !== null) {
                    $newMultilevelNode->next->prev = $newMultilevelNode;
                }
    
                $i++;
            }
            else {
                $newHeadNode = new MultiLevelNode($valueStoredInHead);
                $newHeadNode->next = $newMultilevelNode;
                $newMultilevelNode->prev = $newHeadNode;
    
                if ($mostRecentlyAddedHeadNode === null) {
                    $this->head->above = $newHeadNode;
                    $newHeadNode->below = $this->head;
                }
                else {
                    $mostRecentlyAddedHeadNode->above = $newHeadNode;
                    $newHeadNode->below = $mostRecentlyAddedHeadNode;
                }
    
                $mostRecentlyAddedHeadNode = $newHeadNode;
                $this->numLevels++;
            }
    
            $mostRecentlyAddedMultilevelNode->above = $newMultilevelNode;
            $newMultilevelNode->below = $mostRecentlyAddedMultilevelNode;
    
            $mostRecentlyAddedMultilevelNode = $newMultilevelNode;
    
            $randomNumber = rand(1, 10);
        }
    
        if ($mostRecentlyAddedHeadNode !== null) {
            $this->head = $mostRecentlyAddedHeadNode;
        }
    }
    


    public function delete(int $value): void {
        $currNode = $this->head;

        if ($currNode == null || $currNode->data > $value) {
            return;
        }

        while ($currNode !== null) {
            if ($currNode->data == $value) {
                if ($currNode->prev !== null) {
                    $currNode->prev->next = $currNode->next;
                }

                if ($currNode->next !== null) {
                    $currNode->next->prev = $currNode->prev;
                }

                $currNode = $currNode->below;
            }
            
            if ($currNode->next == null || $currNode->next->data > $value) {
                $currNode = $currNode->below;
            }
            else {
                $currNode = $currNode->next;
            }
        }
    }
}