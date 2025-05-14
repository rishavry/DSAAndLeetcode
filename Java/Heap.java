package Java;

import java.util.ArrayList;


//to compile: javac Java/Heap.java
//to run: java Java/Heap
public class Heap {
    private ArrayList<Integer> heap = new ArrayList<Integer>();

    String type;


    public Heap(String type) {
        if (type.equals("max")) {
            this.type = "max";
        }
        else {
            this.type = "min";
        }
    }


    public ArrayList<Integer> getHeap() {
        return this.heap;
    }


    public String getType() {
        return this.type;
    }


    public int getSize() {
        return this.heap.size();
    }


    public Integer getRootValue() {
        if (this.heap.size() == 0) {
            return null;
        }

        return this.heap.get(0);
    }


    public void insert(int value) {
        this.heap.add(value);
        this.heapifyFromBottomUp(this.heap.size() - 1);
    }


    public boolean remove(int value) {
        int indexOfValueToRemove = this.heap.indexOf(value);

        if (indexOfValueToRemove == -1) {
            return false;
        }
        else if (indexOfValueToRemove == this.heap.size() - 1) {
            this.heap.removeLast();
            return true;
        }

        int lastElementOfHeap = this.heap.removeLast();
        this.heap.set(indexOfValueToRemove, lastElementOfHeap);

        this.heapifyFromTopDown(indexOfValueToRemove);

        return true;
    }


    private void heapifyFromBottomUp(int index) {
        if (index == 0) {
            return;
        }

        int value = this.heap.get(index);

        Integer parentIndex = (index - 1) / 2;
        Integer parentValue = this.heap.get(parentIndex);

        this.heap.set(parentIndex, value);
        this.heap.set(index, parentValue);

        this.heapifyFromBottomUp(parentIndex);
    }


    private void heapifyFromTopDown(int index) {
        int value = this.heap.get(index);

        Integer indexOfLeftChild = 2 * index + 1;
        Integer valueOfLeftChild = null;
        if (indexOfLeftChild < this.heap.size()) {
            valueOfLeftChild = this.heap.get(indexOfLeftChild);
        }
        else {
            indexOfLeftChild = null;
        }

        Integer indexOfRightChild = 2 * index + 2;
        Integer valueOfRightChild = null;
        if (indexOfRightChild < this.heap.size()) {
            valueOfRightChild = this.heap.get(indexOfRightChild);
        }
        else {
            indexOfRightChild = null;
        }

        if (this.type.equals("max")) {
            if (indexOfLeftChild != null && valueOfLeftChild > value && (indexOfRightChild == null || valueOfLeftChild >=
            valueOfRightChild)) {
                this.heap.set(indexOfLeftChild, value);
                this.heap.set(index, valueOfLeftChild);

                this.heapifyFromTopDown(indexOfLeftChild);
            }
            else if (indexOfRightChild != null && valueOfRightChild > value && (indexOfLeftChild == null || valueOfRightChild >=
            valueOfLeftChild)) {
                this.heap.set(indexOfRightChild, value);
                this.heap.set(index, valueOfRightChild);

                this.heapifyFromTopDown(indexOfRightChild);
            }
        }
        else {
            if (indexOfLeftChild != null && valueOfLeftChild < value && (indexOfRightChild == null || valueOfLeftChild <=
            valueOfRightChild)) {
                this.heap.set(indexOfLeftChild, value);
                this.heap.set(index, valueOfLeftChild);

                this.heapifyFromTopDown(indexOfLeftChild);
            }
            else if (indexOfRightChild != null && valueOfRightChild < value && (indexOfLeftChild == null || valueOfRightChild <=
            valueOfLeftChild)) {
                this.heap.set(indexOfRightChild, value);
                this.heap.set(index, valueOfRightChild);

                this.heapifyFromTopDown(indexOfRightChild);
            }
        }
    }


    public static void main(String[] args) {}
}