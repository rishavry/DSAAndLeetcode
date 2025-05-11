// compile with: csc C#/DoublyCircularLinkedList.cs
// then, run with: mono C#/DoublyCircularLinkedList.exe
using System;


class DoublyNode
{
    public object data;

    public DoublyNode prev;
    public DoublyNode next;


    public DoublyNode(Object data)
    {
        this.data = data;
    }
}


class DoublyCircularLinkedList
{
    private DoublyNode head;
    private DoublyNode tail;
    
    private int size;


    public DoublyNode GetHead()
    {
        return this.head;
    }


    public DoublyNode GetTail()
    {
        return this.tail;
    }


    public int GetSize()
    {
        return this.size;
    }


    public void AddElementToStart(Object data)
    {
        DoublyNode newHeadNode = new DoublyNode(data);

        if (this.size == 0)
        {
            this.head = newHeadNode;
            this.tail = newHeadNode;

            newHeadNode.next = newHeadNode;
            newHeadNode.prev = newHeadNode;
        }
        else {
            this.head.prev = newHeadNode;
            newHeadNode.next = this.head;
            newHeadNode.prev = this.tail;
            this.tail.next = newHeadNode;
            this.head = newHeadNode;
        }
        
        this.size++;
    }


     public void DeleteFirstElement()
     {
        if (this.size == 0)
        {
            return;
        }
        
        DoublyNode newHeadNode = this.head.next;
        newHeadNode.prev = this.tail;
        this.tail.next = newHeadNode;
        this.head = newHeadNode;

        this.size--;
    }


    public void AddElementToEnd(Object data)
    {
        DoublyNode newTailNode = new DoublyNode(data);

        if (this.size == 0)
        {
            this.head = newTailNode;
            this.tail = newTailNode;

            newTailNode.next = newTailNode;
            newTailNode.prev = newTailNode;
        }
        else
        {
            this.tail.next = newTailNode;
            newTailNode.prev = this.tail;
            newTailNode.next = this.head;
            this.head.prev = newTailNode;
            this.tail = newTailNode;
        }

        this.size++;
    }


    public void DeleteLastElement()
    {
        if (this.size == 0)
        {
            return;
        }
        
        DoublyNode newTailNode = this.tail.prev;
        newTailNode.next = this.head;
        this.head.prev = newTailNode;
        this.tail = newTailNode;

        this.size--;
    }


    public static void Main(String[] args)
    {}
}