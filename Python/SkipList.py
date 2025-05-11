from typing import Any, Optional

import random


#to run this file, use this command: python3 Python/SkipList.py
class MultiLevelNode:
    data: int

    prev: Optional['MultiLevelNode']
    next: Optional['MultiLevelNode']
    above: Optional['MultiLevelNode']
    below: Optional['MultiLevelNode']


    def __init__(self, data):
        self.data = data


class SkipList:
    head: Optional['MultiLevelNode'] # this will be the left-most node of the top-most level
    num_levels:int = 0


    def get_head(self) -> Optional['MultiLevelNode']:
        return self.head
    

    def get_num_levels(self) -> int:
        return self.num_levels


    def search(self, target: int) -> bool:
        curr_node = self.head

        if curr_node is None or curr_node.data > target:
            return False

        while curr_node is not None:
            if curr_node.data == target:
                return True
            
            if curr_node.next is None or curr_node.next.data > target:
                curr_node = curr_node.below
            else:
                curr_node = curr_node.next
        
        return False
    

    def insert(self, value: int) -> None:
        curr_node = self.head

        if curr_node is None:
            new_head_node = MultiLevelNode(value)

            random_number = random.randint(1, 10)
            curr_node = new_head_node

            while random_number <= 5:
                new_multilevel_node = MultiLevelNode(value)

                curr_node.above = new_multilevel_node
                new_multilevel_node.below = curr_node
                self.num_levels+= 1

                curr_node = new_multilevel_node
                random_number = random.randint(1, 10)

            self.head = curr_node
            return

        elif value < curr_node.data:
            most_recently_added_multilevel_node = None

            while curr_node is not None:
                new_multilevel_node = MultiLevelNode(value)
                curr_node.prev = new_multilevel_node
                new_multilevel_node.next = curr_node

                if most_recently_added_multilevel_node is not None:
                    most_recently_added_multilevel_node.below = new_multilevel_node
                    new_multilevel_node.above = most_recently_added_multilevel_node
                else:
                    self.head = new_multilevel_node

                most_recently_added_multilevel_node = new_multilevel_node

                curr_node = curr_node.below
                
            return

        nodes_of_each_level = []

        while curr_node is not None:
            if curr_node.data == value:
                return
            
            if curr_node.data < value:
                if curr_node.next is None or curr_node.next.data > value:
                    nodes_of_each_level.append(curr_node)
                    curr_node = curr_node.below                    
                else:
                    curr_node = curr_node.next


        nodes_of_each_level = nodes_of_each_level[::-1]

        new_multilevel_node = MultiLevelNode(value)
        new_multilevel_node.prev = nodes_of_each_level[0]
        new_multilevel_node.next = nodes_of_each_level[0].next
        nodes_of_each_level[0].next = new_multilevel_node
        if new_multilevel_node.next is not None:
            new_multilevel_node.next.prev = new_multilevel_node

        i = 1
        random_number = random.randint(1, 10)
        most_recently_added_multilevel_node = new_multilevel_node
        most_recently_added_head_node = None
        value_stored_in_head = self.head.data

        while random_number <= 5:
            new_multilevel_node = MultiLevelNode(value)

            if i < len(nodes_of_each_level):
                new_multilevel_node.next = nodes_of_each_level[i].next
                new_multilevel_node.prev = nodes_of_each_level[i]
                nodes_of_each_level[i].next = new_multilevel_node

                if new_multilevel_node.next is not None:
                    new_multilevel_node.next.prev = new_multilevel_node

                i+= 1

            else:
                new_head_node = MultiLevelNode(value_stored_in_head)
                new_head_node.next = new_multilevel_node
                new_multilevel_node.prev = new_head_node
                
                if most_recently_added_head_node is None:
                    self.head.above = new_head_node
                    new_head_node.below = self.head
                else:
                    most_recently_added_head_node.above = new_head_node
                    new_head_node.below = most_recently_added_head_node

                most_recently_added_head_node = new_head_node

                self.num_levels+= 1

            most_recently_added_multilevel_node.above = new_multilevel_node
            new_multilevel_node.below = most_recently_added_multilevel_node

            most_recently_added_multilevel_node = new_multilevel_node
            
            random_number = random.randint(1, 10)
        
        if most_recently_added_head_node is not None:
            self.head = most_recently_added_head_node


    def delete(self, value: int) -> None:
        curr_node = self.head

        if curr_node is None or curr_node.data > value:
            return

        while curr_node is not None:
            if curr_node.data == value:
                if curr_node.prev is not None:
                    curr_node.prev.next = curr_node.next
                if curr_node.next is not None:
                    curr_node.next.prev = curr_node.prev

                curr_node = curr_node.below
            
            if curr_node.next is None or curr_node.next.data > value:
                curr_node = curr_node.below
            else:
                curr_node = curr_node.next
    
