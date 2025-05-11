from typing import List


#to run this file, use this command: python3 Python/DisjointSet.py
class DisjointSet:
    size: int

    parents: List[int]
    ranks = List[int]
    sizes = List[int]


    def __init__(self, size: int):
        self.size = size
        self.parents = [i for i in range(size)]
        self.ranks = [0 for _ in range(size)]
        self.sizes = [1 for _ in range(size)]


    #returns the root-member of an element's set
    def find(self, element: int) -> int:
        root = self.parents[element]

        if root == element:
            return root
        
        root = self.find(root)
        return root


    #unites two elements based on the ranks of their respective sets
    def union_by_rank(self, x: int, y: int) -> None:
        root_x = self.find(x)
        root_y = self.find(y)

        if root_x == root_y:
            return
        
        rank_x = self.ranks[root_x]
        rank_y = self.ranks[root_y]

        if rank_x < rank_y:
            self.parents[root_x] = root_y
            self.sizes[root_y]+= self.sizes[root_x]
        elif rank_y < rank_x:
            self.parents[root_y] = root_x
            self.sizes[root_x]+= self.sizes[root_y]
        else:
            self.parents[root_x] = root_y
            self.ranks[root_y]+= 1 
            self.sizes[root_y]+= self.sizes[root_x]


    #unites two elements based on the sizes of their respective sets
    def union_by_size(self, x: int, y: int) -> None:
        root_x = self.find(x)
        root_y = self.find(y)

        if root_x == root_y:
            return
        
        size_x = self.ranks[root_x]
        size_y = self.ranks[root_y]

        rank_x = self.ranks[root_x]
        rank_y = self.ranks[root_y]

        if size_x < size_y:
            self.parents[root_x] = root_y
            self.sizes[root_y]+= self.sizes[root_x]

            if rank_x == rank_y:
                self.ranks[root_y]+= 1
        elif size_y < size_x:
            self.parents[root_y] = root_x
            self.sizes[root_x]+= self.sizes[root_y]

            if rank_x == rank_y:
                self.ranks[root_x]+= 1
        else:
            self.parents[root_x] = root_y
            self.sizes[root_y]+= self.sizes[root_x]

            if rank_x == rank_y:
                self.ranks[root_y]+= 1

