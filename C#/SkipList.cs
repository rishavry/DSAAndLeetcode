// compile with: csc C#/SkipList.cs
// then, run with: mono C#/SkipList.exe
using System;
using System.Collections.Generic;


class MultiLevelNode
{
    public int data;

    public MultiLevelNode prev;
    public MultiLevelNode next;
    public MultiLevelNode above;
    public MultiLevelNode below;


    public MultiLevelNode(int data)
    {
        this.data = data;
    }
}



class SkipList
{
    private MultiLevelNode head;
    private int numLevels = 0; 


    public MultiLevelNode getHead()
    {
        return this.head;
    }


    public int getNumLevels()
    {
        return this.numLevels;
    }


    public bool search(int target)
    {
        MultiLevelNode currNode = this.head;

        if (currNode == null || currNode.data > target)
        {
            return false;
        }

        while (currNode != null)
        {
            if (currNode.data == target)
            {
                return true;
            }
            
            if (currNode.next == null || currNode.next.data > target)
            {
                currNode = currNode.below;
            }
            else
            {
                currNode = currNode.next;
            }
        }
        
        return false;
    }


    public void insert(int value)
    {
        MultiLevelNode currNode = this.head;
        Random random = new Random();

        int randomNumber;
        MultiLevelNode mostRecentlyAddedMultilevelNode;
        MultiLevelNode newMultilevelNode;

        if (currNode == null)
        {
            MultiLevelNode newHeadNode = new MultiLevelNode(value);

            randomNumber = random.Next(1, 11);
            currNode = newHeadNode;

            while (randomNumber <= 5)
            {
                newMultilevelNode = new MultiLevelNode(value);

                currNode.above = newMultilevelNode;
                newMultilevelNode.below = currNode;
                this.numLevels++;

                currNode = newMultilevelNode;
                randomNumber = random.Next(1, 11);
            }

            this.head = currNode;
            return;
        }
        else if (value < currNode.data)
        {
            mostRecentlyAddedMultilevelNode = null;

            while (currNode != null)
            {
                newMultilevelNode = new MultiLevelNode(value);
                currNode.prev = newMultilevelNode;
                newMultilevelNode.next = currNode;

                if (mostRecentlyAddedMultilevelNode != null)
                {
                    mostRecentlyAddedMultilevelNode.below = newMultilevelNode;
                    newMultilevelNode.above = mostRecentlyAddedMultilevelNode;
                }
                else
                {
                    this.head = newMultilevelNode;
                }

                mostRecentlyAddedMultilevelNode = newMultilevelNode;

                currNode = currNode.below;
            }

            return;
        }

        List<MultiLevelNode> nodesOfEachLevel = new List<MultiLevelNode>();

        while (currNode != null)
        {
            if (currNode.data == value)
            {
                return;
            }
            
            if (currNode.data < value)
            {
                if (currNode.next == null || currNode.next.data > value)
                {
                    nodesOfEachLevel.Add(currNode);
                    currNode = currNode.below;
                }                  
                else
                {
                    currNode = currNode.next;
                }
            }
        }

        nodesOfEachLevel.Reverse();

        newMultilevelNode = new MultiLevelNode(value);
        newMultilevelNode.prev = nodesOfEachLevel[0];
        newMultilevelNode.next = nodesOfEachLevel[0].next;
        nodesOfEachLevel[0].next = newMultilevelNode;
        if (newMultilevelNode.next != null)
        {
            newMultilevelNode.next.prev = newMultilevelNode;
        }

        int i = 1;
        randomNumber = random.Next(1, 11);
        mostRecentlyAddedMultilevelNode = newMultilevelNode;
        MultiLevelNode mostRecentlyAddedHeadNode = null;
        int valueStoredInHead = this.head.data;

        while (randomNumber <= 5)
        {
            newMultilevelNode = new MultiLevelNode(value);

            if (i < nodesOfEachLevel.Count)
            {
                newMultilevelNode.next = nodesOfEachLevel[i].next;
                newMultilevelNode.prev = nodesOfEachLevel[i];
                nodesOfEachLevel[i].next = newMultilevelNode;

                if (newMultilevelNode.next != null)
                {
                    newMultilevelNode.next.prev = newMultilevelNode;
                }

                i++;
            }

            else {
                MultiLevelNode newHeadNode = new MultiLevelNode(valueStoredInHead);
                newHeadNode.next = newMultilevelNode;
                newMultilevelNode.prev = newHeadNode;
                
                if (mostRecentlyAddedHeadNode == null)
                {
                    this.head.above = newHeadNode;
                    newHeadNode.below = this.head;
                }
                else {
                    mostRecentlyAddedHeadNode.above = newHeadNode;
                    newHeadNode.below = mostRecentlyAddedHeadNode;
                }

                mostRecentlyAddedHeadNode = newHeadNode;

                this.numLevels++;
            }

            mostRecentlyAddedMultilevelNode.above = newMultilevelNode;
            newMultilevelNode.below = mostRecentlyAddedMultilevelNode;

            mostRecentlyAddedMultilevelNode = newMultilevelNode;
            
            randomNumber = random.Next(1, 11);
        }
        
        if (mostRecentlyAddedHeadNode != null)
        {
            this.head = mostRecentlyAddedHeadNode;
        }
    }


    public void delete(int value)
    {
        MultiLevelNode currNode = this.head;

        if (currNode == null || currNode.data > value)
        {
            return;
        }

        while (currNode != null)
        {
            if (currNode.data == value)
            {
                if (currNode.prev != null)
                {
                    currNode.prev.next = currNode.next;
                }
                if (currNode.next != null)
                {
                    currNode.next.prev = currNode.prev;
                }

                currNode = currNode.below;
            }
            
            if (currNode.next == null || currNode.next.data > value)
            {
                currNode = currNode.below;
            }
            else
            {
                currNode = currNode.next;
            }
        }
    }


    public static void Main(String[] args)
    {}
}