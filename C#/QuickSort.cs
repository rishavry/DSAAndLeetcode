using System;
using System.Linq;
using System.Collections.Generic;


// compile with: csc C#/QuickSort.cs
// then, run with: mono QuickSort.exe
class QuickSort
{
    public List<int> SortArray(string sortType, List<int> elementsToSort)
    {
        int numElementsToSort = elementsToSort.Count;
        if (numElementsToSort < 2)
        {
            return elementsToSort;
        }

        Random rand = new Random();
        int pivotIndex = rand.Next(0, numElementsToSort);
        int pivotElement = elementsToSort[pivotIndex];

        List<int> elementsSmallerThanPivotElement = new List<int>();
        List<int> elementsGreaterThanOrEqualToPivotElement = new List<int>(); 
        
        for(int i=0; i<numElementsToSort; i++)
        {
            if (i==pivotIndex)
            {
                continue;
            }

            int currElement = elementsToSort[i];

            if (currElement < pivotElement)
            {
                elementsSmallerThanPivotElement.Add(currElement);
            }
            else
            {
                elementsGreaterThanOrEqualToPivotElement.Add(currElement);
            }
        }

        if (sortType == "ascending")
        {
            return SortArray(sortType, elementsSmallerThanPivotElement)
                .Concat(new List<int> { pivotElement })
                .Concat(SortArray(sortType, elementsGreaterThanOrEqualToPivotElement))
                .ToList();
        } 

        return SortArray(sortType, elementsGreaterThanOrEqualToPivotElement)
            .Concat(new List<int> { pivotElement })
            .Concat(SortArray(sortType, elementsSmallerThanPivotElement))
            .ToList();
    }


    public static void Main(String[] args)
    {}
}