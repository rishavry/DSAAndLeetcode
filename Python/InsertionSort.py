from typing import List


# to run, use: python3 Python/InsertionSort.py
class InsertionSort:
    def sort_elements_from_start(sort_type: str, elements_to_sort: List[int]) -> List[int]:
        if sort_type == 'ascending':
            for i in range(1, len(elements_to_sort)):
                unsorted_element_to_insert_into_sorted_section = elements_to_sort[i]
                unsorted_element_has_been_inserted = False

                for j in range(i, 0, -1):
                    prev_element = elements_to_sort[j-1]

                    if unsorted_element_to_insert_into_sorted_section >= prev_element:
                        elements_to_sort[j] = unsorted_element_to_insert_into_sorted_section
                        unsorted_element_has_been_inserted = True
                        break
                    else:
                        elements_to_sort[j] = prev_element
                        pass
                
                if not unsorted_element_has_been_inserted:
                    elements_to_sort[0] = unsorted_element_to_insert_into_sorted_section
        else:
            for i in range(1, len(elements_to_sort)):
                unsorted_element_to_insert_into_sorted_section = elements_to_sort[i]
                unsorted_element_has_been_inserted = False

                for j in range(i, 0, -1):
                    prev_element = elements_to_sort[j-1]

                    if unsorted_element_to_insert_into_sorted_section <= prev_element:
                        elements_to_sort[j] = unsorted_element_to_insert_into_sorted_section
                        unsorted_element_has_been_inserted = True
                        break
                    else:
                        elements_to_sort[j] = prev_element
                        pass
                
                if not unsorted_element_has_been_inserted:
                    elements_to_sort[0] = unsorted_element_to_insert_into_sorted_section
        
        return elements_to_sort


    def sort_elements_from_end(sort_type: str, elements_to_sort: List[int]) -> List[int]:
        if sort_type == 'ascending':
            for i in range(len(elements_to_sort)-2, -1, -1):
                unsorted_element_to_insert_into_sorted_section = elements_to_sort[i]
                unsorted_element_has_been_inserted = False

                for j in range(i, len(elements_to_sort)-1):
                    next_element = elements_to_sort[j+1]

                    if unsorted_element_to_insert_into_sorted_section <= next_element:
                        elements_to_sort[j] = unsorted_element_to_insert_into_sorted_section
                        unsorted_element_has_been_inserted = True
                        break
                    else:
                        elements_to_sort[j] = next_element
                        pass
                
                if not unsorted_element_has_been_inserted:
                    elements_to_sort[-1] = unsorted_element_to_insert_into_sorted_section
        else:
            for i in range(len(elements_to_sort)-2, -1, -1):
                unsorted_element_to_insert_into_sorted_section = elements_to_sort[i]
                unsorted_element_has_been_inserted = False

                for j in range(i, len(elements_to_sort)-1):
                    next_element = elements_to_sort[j+1]

                    if unsorted_element_to_insert_into_sorted_section >= next_element:
                        elements_to_sort[j] = unsorted_element_to_insert_into_sorted_section
                        unsorted_element_has_been_inserted = True
                        break
                    else:
                        elements_to_sort[j] = next_element
                        pass
                
                if not unsorted_element_has_been_inserted:
                    elements_to_sort[-1] = unsorted_element_to_insert_into_sorted_section
                
        return elements_to_sort