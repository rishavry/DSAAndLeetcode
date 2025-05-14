using System;
using System.Linq;
using System.Collections.Generic;


// compile with: csc C#/SegmentTree.cs
// then, run with: mono SegmentTree.exe
class SegmentTreeNode
{
    public int value;

    public int segmentMin;
    public int segmentMax;

    public SegmentTreeNode parent;

    public SegmentTreeNode leftChild;
    public SegmentTreeNode rightChild;


    public SegmentTreeNode(int value, int segmentMin, int segmentMax)
    {
        this.value = value;

        this.segmentMin = segmentMin;
        this.segmentMax = segmentMax;
    }
}


class SegmentTree //for sums
{
    private SegmentTreeNode root;

    private Dictionary<int, SegmentTreeNode> indicesAndTheirNodes = new Dictionary<int, SegmentTreeNode>();

    private int[] data;

    private int numNodes = 0;


    public SegmentTree(int[] data)
    {
        this.data = data;
        this.createSegmentTreeOfData(null, "", 0, data.Length);
    }


    public SegmentTreeNode getRoot()
    {
        return this.root;
    }


    public int[] getData()
    {
        return this.data;
    }


    public int getNumNodes()
    {
        return this.numNodes;
    }


    private void createSegmentTreeOfData(SegmentTreeNode parentNode, string leftOrRightChildText, int segmentMin, int
    segmentMax)
    {
        SegmentTreeNode newNode = new SegmentTreeNode(
            this.data.Skip(segmentMin).Take(segmentMax - segmentMin + 1).Sum(),
            segmentMin,
            segmentMax
        );
        
        if (parentNode == null)
        {
            this.root = newNode;
        }
        else
        {
            if (leftOrRightChildText == "left")
            {
                parentNode.leftChild = newNode;
            }
            else
            {
                parentNode.rightChild = newNode;
            }
            
            newNode.parent = parentNode;
        }

        this.numNodes++;

        if (segmentMin == segmentMax)
        {
            this.indicesAndTheirNodes[segmentMin] = newNode;
        }
        else
        {
            this.createSegmentTreeOfData(newNode, "left", segmentMin, segmentMax/2);
            this.createSegmentTreeOfData(newNode, "right", segmentMax/2 + 1, segmentMax);
        }
    }


    public void updateValueAtIndex(int index, int newValue)
    {
        int originalValueAtIndex = this.data[index];

        this.data[index] = newValue;
        this.indicesAndTheirNodes[index].value = newValue;

        int newValDiff = newValue - originalValueAtIndex;

        SegmentTreeNode currNode = this.indicesAndTheirNodes[index];

        while (currNode != null)
        {
            currNode.value+= newValDiff;

            currNode = currNode.parent;
        }
    }


    public int getSumOfSegment(int segmentMin, int segmentMax)
    {
        SegmentTreeNode currNode = this.root;

        while (currNode != null)
        {
            int currSegmentMin = currNode.segmentMin;
            int currSegmentMax = currNode.segmentMax;

            if (currSegmentMin == segmentMin && currSegmentMax == segmentMax)
            {
                return currSegmentMin + currSegmentMax;
            }

            if (currSegmentMin == segmentMin && currSegmentMax < segmentMax)
            {
                return currNode.value + this.getSumOfSegment(currSegmentMax + 1, segmentMax);
            }

            SegmentTreeNode currLeftChild = currNode.leftChild;
            SegmentTreeNode currRightChild = currNode.rightChild;

            int leftChildSegmentMin = currLeftChild.segmentMin;
            int leftChildSegmentMax = currLeftChild.segmentMax;

            if (segmentMin >= leftChildSegmentMin && segmentMin <= leftChildSegmentMax)
            {
                currNode = currLeftChild;
            }

            int rightChildSegmentMin = currRightChild.segmentMin;
            int rightChildSegmentMax = currRightChild.segmentMax;

            if (segmentMin >= rightChildSegmentMin && segmentMin <= rightChildSegmentMax)
            {
                currNode = currRightChild;
            }
        }

        return 0; //this code will not be reached
    }


    public static void Main(String[] args)
    {}
}