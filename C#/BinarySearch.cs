using System;


// compile with: csc C#/BinarySearch.cs
// then, run with: mono BinarySearch.exe
class BinarySearch
{
    public bool SearchForNumberInSortedList(int[] sortedList, int target)
    {
        int left = 0;
        int right = sortedList.Length - 1;

        while (left <= right)
        {
            int middle = (left + right)/2;
            int middleElement = sortedList[middle];

            if (middleElement == target)
            {
                return true;
            }

            if (target > middleElement)
            {
                left = middle + 1;
            }
            else
            {
                right = middle - 1;
            }
        }

        return false;
    }

    public static void Main(String[] args)
    {}
}