#to run this file, use this command: python3 Python/RedBlackTree.py
class RedBlackNode:
    value: int

    is_red: bool = True
    is_double_black: bool = False

    parent: 'RedBlackNode'
    is_left_child_of_parent: bool

    left_child: 'RedBlackNode'
    right_child: 'RedBlackNode'


    def __init__(self, value: int):
        self.value = value


class RedBlackTree:
    root: 'RedBlackNode'
    size: int = 0


    def get_root(self) -> 'RedBlackNode':
        return self.root


    def get_size(self) -> int:
        return self.size


    def search_for_value(self, value: int) -> bool:
        if self.root is None:
            return False
        
        curr_node = self.root

        while curr_node is not None:
            if curr_node.value == value:
                return True
            elif curr_node.value > value:
                curr_node = curr_node.left_child
            else:
                curr_node = curr_node.right_child

        return False


    def insert_value(self, value: int) -> bool:
        if self.root is None:
            new_node = RedBlackNode(value)
            new_node.is_red = False
            self.root = new_node
            return True
        
        curr_node = self.root
        new_node_is_left_child = False

        while True:
            if curr_node.value == value:
                return False
            elif curr_node.value > value:
                if curr_node.left_child is not None:
                    curr_node = curr_node.left_child
                else:
                    new_node_is_left_child = True
                    break
            else:
                if curr_node.right_child is not None:
                    curr_node = curr_node.right_child
                else:
                    new_node_is_left_child = False
                    break
        
        parent_node = curr_node
        new_node = RedBlackNode(value)
        new_node.parent = parent_node

        if new_node_is_left_child:
            new_node.is_left_child_of_parent = True
            parent_node.left_child = new_node
        else:
            new_node.is_left_child_of_parent = False
            parent_node.right_child = new_node

        RedBlackTree.fix_red_black_tree_after_insert(new_node)

        return True
    

    def fix_red_black_tree_after_insert(curr_node: 'RedBlackNode') -> None:
        parent_node = curr_node.parent

        if not parent_node.is_red:
            return

        grandparent_node = parent_node.parent

        uncle_node = None
        if parent_node.is_left_child_of_parent:
            uncle_node = grandparent_node.right_child
        else:
            uncle_node = grandparent_node.left_child

        if uncle_node is not None and uncle_node.is_red:
            parent_node.is_red = not parent_node.is_red
            grandparent_node.is_red = not grandparent_node.is_red
            uncle_node.is_red = not uncle_node.is_red
        else:
            if (curr_node.is_left_child_of_parent and parent_node.is_left_child_of_parent) or (not
            curr_node.is_left_child_of_parent and not parent_node.is_left_child_of_parent):
                if parent_node.is_left_child_of_parent:
                    RedBlackTree.perform_rotation_at_node('right', grandparent_node)
                else:
                    RedBlackTree.perform_rotation_at_node('left', grandparent_node)

                parent_node.is_red = not parent_node.is_red
                grandparent_node.is_red = not grandparent_node.is_red
            else:
                if curr_node.is_left_child_of_parent:
                    RedBlackTree.perform_rotation_at_node('right', parent_node)
                else:
                   RedBlackTree.perform_rotation_at_node('left', parent_node)

                RedBlackTree.fix_red_black_tree_after_insert(parent_node)


    def delete_value(self, value: int) -> bool:
        curr_node = self.root

        while curr_node is not None:
            if curr_node.value == value:
                break
            elif curr_node.value > value:
                curr_node = curr_node.left_child
            else:
                curr_node = curr_node.right_child

        if curr_node is None:
            return False
        
        if curr_node.left_child is None and curr_node.right_child is None:
            if curr_node.is_red:
                if curr_node.is_left_child_of_parent:
                    curr_node.parent.left_child = None
                else:
                    curr_node.parent.right_child = None
            else:
                curr_node.value = None
                curr_node.is_double_black = True
                RedBlackTree.fix_red_black_tree_after_delete(curr_node)
            return True
        
        curr_node_replacement = None

        if curr_node.left_child is not None:
            curr_node_replacement = curr_node.left_child

            while curr_node_replacement.right_child is not None:
                curr_node_replacement = curr_node_replacement.right_child

        else:
            curr_node_replacement = curr_node.right_child

            while curr_node_replacement.left_child is not None:
                curr_node_replacement = curr_node_replacement.left_child

        curr_node.value = curr_node_replacement.value
        RedBlackTree.delete_node(curr_node_replacement)
        
        return True
    

    def delete_node(curr_node: 'RedBlackNode') -> None:
        if curr_node.left_child is None and curr_node.right_child is None:
            if curr_node.is_red:
                if curr_node.is_left_child_of_parent:
                    curr_node.parent.left_child = None
                else:
                    curr_node.parent.right_child = None
            else:
                curr_node.value = None
                curr_node.is_double_black = True
                RedBlackTree.fix_red_black_tree_after_delete(curr_node)
            return
        
        curr_node_replacement = None

        if curr_node.left_child is not None:
            curr_node_replacement = curr_node.left_child

            while curr_node_replacement.right_child is not None:
                curr_node_replacement = curr_node_replacement.right_child

        else:
            curr_node_replacement = curr_node.right_child

            while curr_node_replacement.left_child is not None:
                curr_node_replacement = curr_node_replacement.left_child

        curr_node.value = curr_node_replacement.value
        RedBlackTree.delete_node(curr_node_replacement)
    
    
    def fix_red_black_tree_after_delete(self, curr_node: 'RedBlackNode') -> None: 
        if self.root.value == curr_node.value:
            self.root = None
            return
        
        curr_node_is_left_child_of_parent = curr_node.is_left_child_of_parent
        parent_node = curr_node.parent
        
        sibling_node = None
        if curr_node_is_left_child_of_parent:
            sibling_node = parent_node.right_child
        else:
            sibling_node = parent_node.right_child
        
        sibling_left_child_node = sibling_node.left_child
        sibling_right_child_node = sibling_node.right_child

        sibling_far_child_node = None
        sibling_near_child_node = None

        if curr_node_is_left_child_of_parent:
            sibling_near_child_node = sibling_left_child_node
            sibling_far_child_node = sibling_right_child_node
        else:
            sibling_near_child_node = sibling_right_child_node
            sibling_far_child_node = sibling_left_child_node

        if not sibling_node.is_red and ((sibling_left_child_node is None or not sibling_left_child_node.is_red) and
        (sibling_right_child_node is None or not sibling_right_child_node.is_red)):
            if curr_node.value is None:
                if curr_node_is_left_child_of_parent:
                    curr_node.parent.left_child = None
                else:
                    curr_node.parent.right_child = None
            else:
                curr_node.is_double_black = False
            
            sibling_node.is_red = True

            if parent_node.is_red:
                parent_node.is_red = False
            else:
                parent_node.is_double_black = True
                RedBlackTree.fix_red_black_tree_after_delete(parent_node)

        elif sibling_node.is_red:
            original_sibling_node_is_red = sibling_node.is_red

            sibling_node.is_red = parent_node.is_red
            parent_node.is_red = original_sibling_node_is_red

            if curr_node_is_left_child_of_parent:
                RedBlackTree.perform_rotation_at_node('left', parent_node)
            else:
                RedBlackTree.perform_rotation_at_node('right', parent_node)

            RedBlackTree.fix_red_black_tree_after_delete(curr_node)

        elif not sibling_node.is_red and (sibling_far_child_node is None or not sibling_far_child_node.is_red):
            original_sibling_node_is_red = sibling_node.is_red

            sibling_node.is_red = True
            sibling_near_child_node.is_red = original_sibling_node_is_red

            if curr_node_is_left_child_of_parent:
                RedBlackTree.perform_rotation_at_node('right', sibling_node)
            else:
                RedBlackTree.perform_rotation_at_node('left', sibling_node)

            RedBlackTree.apply_case_6_of_rbt_delete_fixup(curr_node, parent_node, sibling_node, sibling_far_child_node)

        elif not sibling_node.is_red and (sibling_far_child_node is not None and sibling_far_child_node.is_red):
            RedBlackTree.apply_case_6_of_rbt_delete_fixup(curr_node, parent_node, sibling_node, sibling_far_child_node)


    def perform_rotation_at_node(rotation_type: str, curr_node: 'RedBlackNode'):
        parent_node = curr_node.parent
        original_curr_node_is_left_child_of_parent = curr_node.is_left_child_of_parent

        if rotation_type == 'left':
            original_right_child_node = curr_node.right_child
            original_left_child_node_of_right_child_node = curr_node.right_child.left_child

            original_right_child_node.parent = parent_node
            original_right_child_node.left_child = curr_node
            original_right_child_node.is_left_child_of_parent = original_curr_node_is_left_child_of_parent

            if original_curr_node_is_left_child_of_parent:
                parent_node.left_child = original_right_child_node
            else:
                parent_node.right_child = original_right_child_node

            curr_node.parent = original_right_child_node
            curr_node.right_child = original_left_child_node_of_right_child_node
            curr_node.is_left_child_of_parent = True

            original_left_child_node_of_right_child_node.parent = curr_node
            original_left_child_node_of_right_child_node.is_left_child_of_parent = False
        else:
            original_left_child_node = curr_node.left_child
            original_right_child_node_of_left_child_node = curr_node.left_child.right_child

            original_left_child_node.parent = parent_node
            original_left_child_node.right_child = curr_node
            original_left_child_node.is_left_child_of_parent = original_curr_node_is_left_child_of_parent

            if original_curr_node_is_left_child_of_parent:
                parent_node.left_child = original_left_child_node
            else:
                parent_node.right_child = original_left_child_node

            curr_node.parent = original_left_child_node
            curr_node.left_child = original_right_child_node_of_left_child_node
            curr_node.is_left_child_of_parent = False

            original_right_child_node_of_left_child_node.parent = curr_node
            original_right_child_node_of_left_child_node.is_left_child_of_parent = True
    

    def apply_case_6_of_rbt_delete_fixup(curr_node: 'RedBlackNode', parent_node: 'RedBlackNode', sibling_node: 'RedBlackNode',
    sibling_far_child_node) -> None:
        original_parent_node_is_red = parent_node.is_red
        original_sibling_node_is_red = sibling_node.is_red

        parent_node.is_red = original_sibling_node_is_red
        sibling_node.is_red =original_parent_node_is_red

        if curr_node.is_left_child_of_parent:
            RedBlackTree.perform_rotation_at_node('left', parent_node)
        else:
            RedBlackTree.perform_rotation_at_node('right', parent_node)

        curr_node.is_double_black = False

        sibling_far_child_node.is_red = False