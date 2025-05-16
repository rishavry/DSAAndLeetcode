from typing import Dict, List


#to run file, do: python3 Python/RobinKarp.py
class RobinKarp:
    def find_all_occurrences_of_substring_in_string(substring: str, string: str) -> List[int]:
        substring_length = len(substring)

        if substring_length > len(string):
            return []
        
        character_to_value_mappings = RobinKarp.get_character_to_value_mappings(substring + string)

        total_number_of_unique_chars = len(character_to_value_mappings)

        substring_hash_code = RobinKarp.get_hash_code_of_substring(
            character_to_value_mappings, substring, total_number_of_unique_chars
        )

        rolling_substring = string[:substring_length]
        rolling_hash_code = RobinKarp.get_hash_code_of_substring(
            character_to_value_mappings, rolling_substring, total_number_of_unique_chars
        )

        occurrences = []
        
        if rolling_hash_code == substring_hash_code and rolling_substring == substring:
            occurrences.push(0)

        i = 1

        while i + substring_length <= len(string):
            original_first_letter = rolling_substring[0]
            next_last_letter = string[i + substring_length - 1]

            rolling_substring = rolling_substring[1:] + next_last_letter
            rolling_hash_code = RobinKarp.get_rolling_hash_code(
                character_to_value_mappings, original_first_letter, next_last_letter, rolling_hash_code, substring_length,
                total_number_of_unique_chars
            )

            if rolling_hash_code == substring_hash_code and rolling_substring == substring:
                occurrences.push(i)
            i+= 1

        return occurrences
    

    def get_character_to_value_mappings(string: str) -> Dict[str, int]:
        output = {}

        curr_value = 1

        for char in string:
            if char not in output:
                output[char] = curr_value
                curr_value+= 1

        return output

    
    def get_hash_code_of_substring(character_to_value_mappings: Dict[str, int], substring: str, total_number_of_unique_chars:
    int) -> int:
        substring_hash_code = 0

        for i in range(-1, -len(substring)):
            curr_power = abs(i) - 1
            value_of_curr_character = character_to_value_mappings[substring[i]]
            substring_hash_code += value_of_curr_character * (total_number_of_unique_chars ** curr_power)

        return substring_hash_code
    

    def get_rolling_hash_code(character_to_value_mappings: Dict[str, int], original_first_letter: str, next_last_letter: str,
    original_hash_code: int, substring_length: int, total_number_of_unique_chars: int) -> int:
        rolling_hash_code = original_hash_code

        value_of_original_first_letter = character_to_value_mappings[original_first_letter]

        rolling_hash_code -= value_of_original_first_letter * (
            total_number_of_unique_chars ** (substring_length - 1)
        )

        rolling_hash_code *= total_number_of_unique_chars

        value_of_next_last_letter = character_to_value_mappings[next_last_letter]

        rolling_hash_code += value_of_next_last_letter

        return rolling_hash_code