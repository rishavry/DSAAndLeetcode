package Java;


// to compile: javac Java/SelectionSort.java
// to run: java Java/SelectionSort
public class SelectionSort {
    public int[] sortElementsFromStart(String sortType, int[] elementsToSort) {
        if (sortType.equals("ascending")) {
            for (int i=0; i<elementsToSort.length - 1; i++) {
                int currElement = elementsToSort[i];

                int smallestElement = currElement;
                int indexOfSmallestUnsortedElement = i;

                for(int j=i+1; j<elementsToSort.length; j++) {
                    if (elementsToSort[j] < smallestElement) {
                        smallestElement = elementsToSort[j];
                        indexOfSmallestUnsortedElement = j;
                    }
                }

                if (indexOfSmallestUnsortedElement != i) {
                    elementsToSort[indexOfSmallestUnsortedElement] = elementsToSort[i];
                    elementsToSort[i] = smallestElement;
                }
            }
        }
        else {
            for (int i=0; i<elementsToSort.length - 1; i++) {
                int currElement = elementsToSort[i];

                int largestElement = currElement;
                int indexOfLargestUnsortedElement = i;

                for(int j=i+1; j<elementsToSort.length; j++) {
                    if (elementsToSort[j] > largestElement) {
                        largestElement = elementsToSort[j];
                        indexOfLargestUnsortedElement = j;
                    }
                }

                if (indexOfLargestUnsortedElement != i) {
                    elementsToSort[indexOfLargestUnsortedElement] = elementsToSort[i];
                    elementsToSort[i] = largestElement;
                }
            }
        }

        return elementsToSort;
    }


    public int[] sortElementsFromEnd(String sortType, int[] elementsToSort) {
        if (sortType.equals("ascending")) {
            for (int i=elementsToSort.length -1; i>=1; i--) {
                int currElement = elementsToSort[i];

                int largestElement = currElement;
                int indexOfLargestUnsortedElement = i;

                for(int j=i-1; j>=0; j--) {
                    if (elementsToSort[j] > largestElement) {
                        largestElement = elementsToSort[j];
                        indexOfLargestUnsortedElement = j;
                    }
                }

                if (indexOfLargestUnsortedElement != i) {
                    elementsToSort[indexOfLargestUnsortedElement] = elementsToSort[i];
                    elementsToSort[i] = largestElement;
                }
            }
        }
        else {
            for (int i=elementsToSort.length -1; i>=1; i--) {
                int currElement = elementsToSort[i];

                int smallestElement = currElement;
                int indexOfSmallestUnsortedElement = i;

                for(int j=i-1; j>=0; j--) {
                    if (elementsToSort[j] < smallestElement) {
                        smallestElement = elementsToSort[j];
                        indexOfSmallestUnsortedElement = j;
                    }
                }

                if (indexOfSmallestUnsortedElement != i) {
                    elementsToSort[indexOfSmallestUnsortedElement] = elementsToSort[i];
                    elementsToSort[i] = smallestElement;
                }
            }
        }

        return elementsToSort;
    }


    public static void main(String[] args) {}
}