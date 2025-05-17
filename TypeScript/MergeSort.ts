// to run, use: npx ts-node TypeScript/MergeSort.ts
class MergeSort {
    sortArray(sortType: string, elementsToSort: number[]): number[] {
        if (elementsToSort.length < 2) {
            return elementsToSort;
        }

        const numElementsToSort: number = elementsToSort.length;
        const halfwayIndex =  Math.floor(numElementsToSort/2);

        const firstHalfOfElementsToSort: number[] = elementsToSort.slice(0, halfwayIndex);
        const sortedFirstHalfOfElementsToSort: number[] = this.sortArray(sortType, firstHalfOfElementsToSort);

        const secondHalfOfElementsToSort: number[] = elementsToSort.slice(halfwayIndex);
        const sortedSecondHalfOfElementsToSort: number[] = this.sortArray(sortType, secondHalfOfElementsToSort);

        let sortedElements: number[] = [];

        let pointer1 = 0;
        let pointer2 = 0;

        while (true) {
            if (pointer1 == sortedFirstHalfOfElementsToSort.length) {
                sortedElements = [...sortedElements, ...sortedSecondHalfOfElementsToSort.slice(pointer2)];
                break;
            }

            if (pointer2 == sortedSecondHalfOfElementsToSort.length) {
                sortedElements = [...sortedElements, ...sortedFirstHalfOfElementsToSort.slice(pointer1)];
                break;
            }

            const element1 = sortedFirstHalfOfElementsToSort[pointer1];
            const element2 = sortedSecondHalfOfElementsToSort[pointer2];

            if (sortType === 'ascending') {
                if (element1 < element2) {
                    sortedElements.push(element1);
                    pointer1++;
                }
                else {
                    sortedElements.push(element2);
                    pointer2++;
                }
            }
            else {
                if (element1 > element2) {
                    sortedElements.push(element1);
                    pointer1++;
                }
                else {
                    sortedElements.push(element2);
                    pointer2++;
                }
            }
        }

        return sortedElements;
    }
}