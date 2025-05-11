<?php


// to run this file, use this command: php PHP/DoublyCircularLinkedList.php
class DoublyNode {
    public object $data;
    
    public DoublyNode $prev;
    public DoublyNode $next;


    public function __construct(object $data) {
        $this->data = $data;
    }
}


class DoublyCircularLinkedList {    
    private DoublyNode $head;
    private DoublyNode $tail;

    private int $size;


    public function getHead(): DoublyNode {
        return $this->head;
    }


    public function getTail(): DoublyNode {
        return $this->tail;
    }
    

    public function getSize(): int {
        return $this->size;
    }


    public function addElementToStart(object $data): void {
        $newHeadNode = new DoublyNode($data);

        if ($this->size == 0) {
            $this->head = $newHeadNode;
            $this->tail = $newHeadNode;

            $newHeadNode->next = $newHeadNode;
            $newHeadNode->prev = $newHeadNode;
        }
        else {
            $this->head->prev = $newHeadNode;
            $newHeadNode->next = $this->head;
            $newHeadNode->prev = $this->tail;
            $this->tail->next = $newHeadNode;
            $this->head = $newHeadNode;
        }
        
        $this->size++;
    }


    public function deleteFirstElement(): void {
        if ($this->size == 0) {
            return;
        }

        $newHeadNode = $this->head->next;
        $newHeadNode->prev = $this->tail;
        $this->tail->next = $newHeadNode;
        $this->head = $newHeadNode;

        $this->size--;
    }


    public function addElementToEnd(object $data): void {
        $newTailNode = new DoublyNode($data);

        if ($this->size == 0) {
            $this->head = $newTailNode;
            $this->tail = $newTailNode;

            $newTailNode->next = $newTailNode;
            $newTailNode->prev = $newTailNode;
        }
        else {
            $this->tail->next = $newTailNode;
            $newTailNode->prev = $this->tail;
            $newTailNode->next = $this->head;
            $this->head->prev = $newTailNode;
            $this->tail = $newTailNode;
        }

        $this->size++;
    }


    public function deleteLastElement(): void {
        if ($this->size == 0) {
            return;
        }

        $newTailNode = $this->tail->prev;
        $newTailNode->next = $this->head;
        $this->head->prev = $newTailNode;
        $this->tail = $newTailNode;

        $this->size--;
    }
}
