package Java;


// compile with: javac Java/DoublyCircularLinkedList.java 
// then, run with: java Java/DoublyCircularLinkedList
class DoublyNode {
    public Object data;

    public DoublyNode prev;
    public DoublyNode next;


    public DoublyNode(Object data) {
        this.data = data;
    }
}


public class DoublyCircularLinkedList {
    private DoublyNode head;
    private DoublyNode tail;
    
    private int size;


    public DoublyNode getHead() {
        return this.head;
    }


    public DoublyNode getTail() {
        return this.tail;
    }


    public int getSize() {
        return this.size;
    }


    public void addElementToStart(Object data) {
        DoublyNode newHeadNode = new DoublyNode(data);

        if (this.size == 0) {
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


    public void deleteFirstElement() {
        if (this.size == 0) {
            return;
        }
        
        DoublyNode newHeadNode = this.head.next;
        newHeadNode.prev = this.tail;
        this.tail.next = newHeadNode;
        this.head = newHeadNode;

        this.size--;
    }


    public void addElementToEnd(Object data) {
        DoublyNode newTailNode = new DoublyNode(data);

        if (this.size == 0) {
            this.head = newTailNode;
            this.tail = newTailNode;

            newTailNode.next = newTailNode;
            newTailNode.prev = newTailNode;
        }
        else {
            this.tail.next = newTailNode;
            newTailNode.prev = this.tail;
            newTailNode.next = this.head;
            this.head.prev = newTailNode;
            this.tail = newTailNode;
        }

        this.size++;
    }


    public void deleteLastElement() {
        if (this.size == 0) {
            return;
        }
        
        DoublyNode newTailNode = this.tail.prev;
        newTailNode.next = this.head;
        this.head.prev = newTailNode;
        this.tail = newTailNode;

        this.size--;
    }


    public static void main(String[] args) {}
}
