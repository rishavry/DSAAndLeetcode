package Java;


// to compile: javac Java/CycleSort.java
// to run: java Java/CycleSort
public class CycleSort {
    public int[] sortElementsFromStart(String sortType, int[] elementsToSort, int min, int max) {
        for(int i=0; i<elementsToSort.length-1; i++) {
            int currentElement = elementsToSort[i];
            int correctIndexOfElement = -1;

            if (sortType.equals("ascending")) {
                correctIndexOfElement = currentElement - min;

                while (correctIndexOfElement != i) {
                    int elementAtCorrectIndexOfCurrentElement = elementsToSort[correctIndexOfElement];
                    elementsToSort[correctIndexOfElement] = currentElement;
                    elementsToSort[i] = elementAtCorrectIndexOfCurrentElement;

                    currentElement = elementsToSort[i];
                    correctIndexOfElement = currentElement - min;
                }
            }
            else {
                correctIndexOfElement = max - currentElement;

                while (correctIndexOfElement != i) {
                    int elementAtCorrectIndexOfCurrentElement = elementsToSort[correctIndexOfElement];
                    elementsToSort[correctIndexOfElement] = currentElement;
                    elementsToSort[i] = elementAtCorrectIndexOfCurrentElement;

                    currentElement = elementsToSort[i];
                    correctIndexOfElement = max - currentElement;
                }
            }
        }

        return elementsToSort;
    }


    public int[] sortElementsFromEnd(String sortType, int[] elementsToSort, int min, int max) {
        for(int i=elementsToSort.length-1; i>0; i--) {
            int currentElement = elementsToSort[i];
            int correctIndexOfElement = -1;

            if (sortType.equals("ascending")) {
                correctIndexOfElement = currentElement - min;

                while (correctIndexOfElement != i) {
                    int elementAtCorrectIndexOfCurrentElement = elementsToSort[correctIndexOfElement];
                    elementsToSort[correctIndexOfElement] = currentElement;
                    elementsToSort[i] = elementAtCorrectIndexOfCurrentElement;

                    currentElement = elementsToSort[i];
                    correctIndexOfElement = currentElement - min;
                }
            }
            else {
                correctIndexOfElement = max - currentElement;

                while (correctIndexOfElement != i) {
                    int elementAtCorrectIndexOfCurrentElement = elementsToSort[correctIndexOfElement];
                    elementsToSort[correctIndexOfElement] = currentElement;
                    elementsToSort[i] = elementAtCorrectIndexOfCurrentElement;

                    currentElement = elementsToSort[i];
                    correctIndexOfElement = max - currentElement;
                }
            }
        }

        return elementsToSort;
    }


    public static void main(String[] args) {}
}
