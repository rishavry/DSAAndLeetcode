package Java;


// to compile: javac Java/TernarySearch.java
// to run: java Java/TernarySearch
public class TernarySearch {
    public boolean searchForNumberInSortedList(int[] sortedList, int target) {
        int left = 0;
        int right = sortedList.length - 1;

        while (left <= right) {
            int middle1 = (right - left) / 3 + left;
            int middle1Element = sortedList[middle1];

            int middle2 = right - (right - left) / 3;
            int middle2Element = sortedList[middle2];

            if (middle1Element == target || middle2Element == target) {
                return true;
            }

            if (target < middle1Element) {
                right = middle1 - 1;
            }
            else if (target < middle2Element) {
                left = middle1 + 1;
                right = middle2 - 1;
            }
            else {
                left = middle2 + 1;
            }
        }

        return false;
    }


    public static void main(String[] args) {}
}
