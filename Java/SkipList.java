package Java;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Random;


// compile with: javac Java/SkipList.java 
// then, run with: java Java/SkipList
class MultiLevelNode {
    public int data;

    public MultiLevelNode prev;
    public MultiLevelNode next;
    public MultiLevelNode above;
    public MultiLevelNode below;


    public MultiLevelNode(int data) {
        this.data = data;
    }
}


public class SkipList {
    private MultiLevelNode head;
    private int numLevels = 0; 


    public MultiLevelNode getHead() {
        return this.head;
    }


    public int getNumLevels() {
        return this.numLevels;
    }


    public boolean search(int target) {
        MultiLevelNode currNode = this.head;

        if (currNode == null || currNode.data > target) {
            return false;
        }

        while (currNode != null) {
            if (currNode.data == target) {
                return true;
            }
            
            if (currNode.next == null || currNode.next.data > target) {
                currNode = currNode.below;
            }
            else {
                currNode = currNode.next;
            }
        }
        
        return false;
    }


    public void insert(int value) {
        MultiLevelNode currNode = this.head;

        if (currNode == null) {
            MultiLevelNode newHeadNode = new MultiLevelNode(value);

            int randomNumber = getRandomInteger(1, 10);
            currNode = newHeadNode;

            while (randomNumber <= 5) {
                MultiLevelNode newMultilevelNode = new MultiLevelNode(value);

                currNode.above = newMultilevelNode;
                newMultilevelNode.below = currNode;
                this.numLevels++;

                currNode = newMultilevelNode;
                randomNumber = getRandomInteger(1, 10);
            }

            this.head = currNode;
            return;
        }
        else if (value < currNode.data) {
            MultiLevelNode mostRecentlyAddedMultilevelNode = null;

            while (currNode != null) {
                MultiLevelNode newMultilevelNode = new MultiLevelNode(value);
                currNode.prev = newMultilevelNode;
                newMultilevelNode.next = currNode;

                if (mostRecentlyAddedMultilevelNode != null) {
                    mostRecentlyAddedMultilevelNode.below = newMultilevelNode;
                    newMultilevelNode.above = mostRecentlyAddedMultilevelNode;
                }
                else {
                    this.head = newMultilevelNode;
                }

                mostRecentlyAddedMultilevelNode = newMultilevelNode;

                currNode = currNode.below;
            }

            return;
        }

        ArrayList<MultiLevelNode> nodesOfEachLevel = new ArrayList<MultiLevelNode>();

        while (currNode != null) {
            if (currNode.data == value) {
                return;
            }
            
            if (currNode.data < value) {
                if (currNode.next == null || currNode.next.data > value) {
                    nodesOfEachLevel.add(currNode);
                    currNode = currNode.below;
                }                  
                else {
                    currNode = currNode.next;
                }
            }
        }

        Collections.reverse(nodesOfEachLevel);

        MultiLevelNode newMultilevelNode = new MultiLevelNode(value);
        newMultilevelNode.prev = nodesOfEachLevel.get(0);
        newMultilevelNode.next = nodesOfEachLevel.get(0).next;
        nodesOfEachLevel.get(0).next = newMultilevelNode;
        if (newMultilevelNode.next != null) {
            newMultilevelNode.next.prev = newMultilevelNode;
        }

        int i = 1;
        int randomNumber = getRandomInteger(1, 10);
        MultiLevelNode mostRecentlyAddedMultilevelNode = newMultilevelNode;
        MultiLevelNode mostRecentlyAddedHeadNode = null;
        int valueStoredInHead = this.head.data;

        while (randomNumber <= 5) {
            newMultilevelNode = new MultiLevelNode(value);

            if (i < nodesOfEachLevel.size()) {
                newMultilevelNode.next = nodesOfEachLevel.get(i).next;
                newMultilevelNode.prev = nodesOfEachLevel.get(i);
                nodesOfEachLevel.get(i).next = newMultilevelNode;

                if (newMultilevelNode.next != null) {
                    newMultilevelNode.next.prev = newMultilevelNode;
                }

                i++;
            }

            else {
                MultiLevelNode newHeadNode = new MultiLevelNode(valueStoredInHead);
                newHeadNode.next = newMultilevelNode;
                newMultilevelNode.prev = newHeadNode;
                
                if (mostRecentlyAddedHeadNode == null) {
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
            
            randomNumber = getRandomInteger(1, 10);
        }
        
        if (mostRecentlyAddedHeadNode != null) {
            this.head = mostRecentlyAddedHeadNode;
        }
    }


    public void delete(int value) {
        MultiLevelNode currNode = this.head;

        if (currNode == null || currNode.data > value) {
            return;
        }

        while (currNode != null) {
            if (currNode.data == value) {
                if (currNode.prev != null) {
                    currNode.prev.next = currNode.next;
                }
                if (currNode.next != null) {
                    currNode.next.prev = currNode.prev;
                }

                currNode = currNode.below;
            }
            
            if (currNode.next == null || currNode.next.data > value) {
                currNode = currNode.below;
            }
            else {
                currNode = currNode.next;
            }
        }
    }


    public static int getRandomInteger(int min, int max) {
        Random rand = new Random();
        return rand.nextInt(max) + min;
    }


    public static void main(String[] args) {}
}