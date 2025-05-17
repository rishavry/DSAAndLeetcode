from typing import List


# to run, use: python3 Python/RadixSort.py
class RadixSort:
    def sort_elements(sort_type: str, elements_to_sort: List[int]) -> List[int]:
        numbers_and_their_strings = {}
        for element in elements_to_sort:
            numbers_and_their_strings[element] = str(element)

        curr_digit = 1

        sorted_elements = []

        all_elements_are_in_bucket_0 = False

        while not all_elements_are_in_bucket_0:
            buckets = {
                0: [],
                1: [],
                2: [],
                3: [],
                4: [],
                5: [],
                6: [],
                7: [],
                8: [],
                9: [],
                10: []
            }
            
            all_elements_are_in_bucket_0 = True

            for element in elements_to_sort:
                stringified_element = numbers_and_their_strings[element]
                if len(stringified_element) < curr_digit:
                    buckets[0].append(element)
                else:
                    all_elements_are_in_bucket_0 = False
                    buckets[int(stringified_element[-curr_digit])].append(element)

            sorted_elements = []

            if sort_type == 'ascending':
                for i in range(11):
                    sorted_elements += buckets[i]
            else:
                for i in range(10, -1, -1):
                    sorted_elements += buckets[i]

        return sorted_elements