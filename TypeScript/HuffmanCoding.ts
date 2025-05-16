// to run, use: npx ts-node TypeScript/HuffmanCoding.ts
class HuffmanCoding {
    compressTextWithFixedSizeBits(text: string): { fixedSize: number, characterToBinaryValueMappings: Record<string, any>,
    compressedText: string } {
        const characterToBinaryValueMappings:Record<string, any> = {};
        let currValue = 0;

        for (let i=0; i<text.length; i++) {
            const currChar = text[i];

            if (!(currChar in characterToBinaryValueMappings)) {
                characterToBinaryValueMappings[currChar] = currValue;
                currValue++;
            }
        }

        const fixedNumberOfBits = this.getMinimumNumberOfBitsNeededToRepresentNumber(currValue);
        for (let character of Object.keys(characterToBinaryValueMappings)) {
            characterToBinaryValueMappings[character] = this.getStringifiedBinaryRepresentationOfNumber(
                characterToBinaryValueMappings[character], fixedNumberOfBits
            );
        }

        let compressedText = '';
        for (let i=0; i<text.length; i++) {
            compressedText += characterToBinaryValueMappings[text[i]];
        }

        return {
            fixedSize: fixedNumberOfBits,
            characterToBinaryValueMappings: characterToBinaryValueMappings,
            compressedText: compressedText,
        }
    }


    getMinimumNumberOfBitsNeededToRepresentNumber(number: number): number {
        if (number == 0) return 1;

        return Math.floor(Math.log2(number)) + 1;
    }

    
    getStringifiedBinaryRepresentationOfNumber(number: number, numBits: number): string {
        let valueRemaining = number;
        let stringifiedBinaryRepresentationOfNumber = '';

        for (let i=numBits-1; i>=0; i--) {
            if (valueRemaining - 2**i < 0) {
                stringifiedBinaryRepresentationOfNumber += '0';
            }
            else {
                stringifiedBinaryRepresentationOfNumber += '1';

                valueRemaining-= 2**i;
            }
        }

        return stringifiedBinaryRepresentationOfNumber;
    }


    decompressTextWithFixedSizeBits(fixedSize: number, binaryValueToCharacterMappings: Record<string, string>, compressedText:
    string): string {
        let decompressedText = '';

        for (let i = 0; i <= compressedText.length - fixedSize; i+=fixedSize) {
            decompressedText += binaryValueToCharacterMappings[compressedText.substring(i, i + fixedSize)]
        }

        return decompressedText;
    }


    compressTextWithVariableSizedBits(text: string): any {
        const charactersAndTheirCounts: Record<string, number> = {};
        for (let i=0; i<text.length; i++) {
            const currChar = text[i];

            if (!(currChar in charactersAndTheirCounts)) {
                charactersAndTheirCounts[currChar] = 0;
            }

            charactersAndTheirCounts[currChar]++;
        }

        const charsInAscOrderOfTheirCounts = Object.keys(charactersAndTheirCounts).sort((char1, char2) =>
            charactersAndTheirCounts[char1] - charactersAndTheirCounts[char2]
        );

        let listOfRelevantInfoOnEachChar:any[] = [];

        for (let char of charsInAscOrderOfTheirCounts) {
            const charsAndTheirStrBinaryEncodings: Record<string, string> = {};
            charsAndTheirStrBinaryEncodings[char] = '';

            listOfRelevantInfoOnEachChar.push({
                representative: charactersAndTheirCounts[char],
                charsAndTheirStrBinaryEncodings: charsAndTheirStrBinaryEncodings
            })
        }


        while (listOfRelevantInfoOnEachChar.length > 1) {
            const newRelevantInfoElement:any = {
                representative: listOfRelevantInfoOnEachChar[0].representative + listOfRelevantInfoOnEachChar[1].representative,
                charsAndTheirStrBinaryEncodings: {}
            };

            for (let char of Object.keys(listOfRelevantInfoOnEachChar[0].charsAndTheirStrBinaryEncodings)) {
                newRelevantInfoElement.charsAndTheirStrBinaryEncodings[char] = '0' +
                listOfRelevantInfoOnEachChar[0].charsAndTheirStrBinaryEncodings[char];
            }

            for (let char of Object.keys(listOfRelevantInfoOnEachChar[0].charsAndTheirStrBinaryEncodings)) {
                newRelevantInfoElement.charsAndTheirStrBinaryEncodings[char] = '1' +
                listOfRelevantInfoOnEachChar[1].charsAndTheirStrBinaryEncodings[char];
            }

            listOfRelevantInfoOnEachChar = listOfRelevantInfoOnEachChar.slice(2);

            let newRelevantInfoElementHasBeenInserted = false;

            for (let i=listOfRelevantInfoOnEachChar.length-1; i>=0; i--) {
                if (newRelevantInfoElement.representative > listOfRelevantInfoOnEachChar[i].representative) {
                    listOfRelevantInfoOnEachChar.splice(i, 0, newRelevantInfoElement);
                    newRelevantInfoElementHasBeenInserted = true;
                    break;
                }
            }

            if (!newRelevantInfoElementHasBeenInserted) {
                listOfRelevantInfoOnEachChar.splice(0, 0, newRelevantInfoElement);
            }
        }

        const characterToBinaryValueMappings: Record<string, any> = listOfRelevantInfoOnEachChar[0]
        .charsAndTheirStrBinaryEncodings;

        let compressedText = '';
        for (let i=0; i<text.length; i++) {
            compressedText += characterToBinaryValueMappings[text[i]];
        }

        return {
            characterToBinaryValueMappings: characterToBinaryValueMappings,
            compressedText: compressedText,
        }
    }


    decompressTextWithVariableSizedBits(binaryValueToCharacterMappings: Record<string, string>, compressedText: string): string {
        let decompressedText = '';
        let currBinaryValue = '';

        for (let i=0; i<compressedText.length; i++) {
            currBinaryValue += compressedText[i];

            if (currBinaryValue in binaryValueToCharacterMappings) {
                decompressedText += binaryValueToCharacterMappings[currBinaryValue];
                currBinaryValue = '';
            }
        }

        return decompressedText;
    }
}