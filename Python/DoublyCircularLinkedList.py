from typing import Any, Optional


#to run this file, use this command: python3 Python/DoublyCircularLinkedList.py
class DoublyNode:
    data: Any
    
    prev: Optional['DoublyNode']
    next: Optional['DoublyNode']


    def __init__(self, data):
        self.data = data


class DoublyCircularLinkedList:
    head: Optional['DoublyNode']
    tail: Optional['DoublyNode']

    size: int


    def get_head(self) -> Optional['DoublyNode']:
        return self.head


    def get_tail(self) -> Optional['DoublyNode']:
        return self.tail
    

    def get_size(self) -> int:
        return self.size


    def add_element_to_start(self, data: Any) -> None:
        new_head_node = DoublyNode(data)

        if self.size == 0:
            self.head = new_head_node
            self.tail = new_head_node

            new_head_node.next = new_head_node
            new_head_node.prev = new_head_node
        
        else:
            self.head.prev = new_head_node
            new_head_node.next = self.head
            new_head_node.prev = self.tail
            self.tail.next = new_head_node;
            self.head = new_head_node
        
        self.size+= 1


    def delete_first_element(self) -> None:
        if self.size == 0:
            return
        
        new_head_node = self.head.next
        new_head_node.prev = self.tail
        self.tail.next = new_head_node
        self.head = new_head_node

        self.size-= 1


    def add_element_to_end(self, data: Any) -> None:
        new_tail_node = DoublyNode(data)

        if self.size == 0:
            self.head = new_tail_node
            self.tail = new_tail_node

            new_tail_node.next = new_tail_node
            new_tail_node.prev = new_tail_node
        
        else:
            self.tail.next = new_tail_node
            new_tail_node.prev = self.tail
            new_tail_node.next = self.head
            self.head.prev = new_tail_node
            self.tail = new_tail_node

        self.size+= 1


    def delete_last_element(self) -> None:
        if self.size == 0:
            return
        
        new_tail_node = self.tail.prev
        new_tail_node.next = self.head
        self.head.prev = new_tail_node
        self.tail = new_tail_node

        self.size-= 1
