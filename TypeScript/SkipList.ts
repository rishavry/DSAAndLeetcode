// to run this file, use this command: npx ts-node TypeScript/SkipList.ts
class MultiLevelNode {
    data!:number;

    prev!:MultiLevelNode|null;
    next!:MultiLevelNode|null;
    above!:MultiLevelNode|null;
    below!:MultiLevelNode|null;


    constructor(data: number) {
        this.data = data;
    }
}


class SkipList {
    head!:MultiLevelNode|null;
    numLevels:number = 0;


    getHead(): MultiLevelNode|null {
        return this.head;
    }


    getNumLevels(): number {
        return this.numLevels;
    }


    search(target: number): boolean {
        let currNode = this.head

        if (currNode == null || currNode.data > target) {
            return false;
        }

        while (currNode !== null) {
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


    insert(value: number): void {
        let currNode = this.head;

        if (currNode == null) {
            const newHeadNode = new MultiLevelNode(value);

            let randomNumber = this.getRandomInteger(1, 10);
            currNode = newHeadNode;

            while (randomNumber <= 5) {
                const newMultilevelNode = new MultiLevelNode(value);

                currNode!.above = newMultilevelNode;
                newMultilevelNode.below = currNode;
                this.numLevels++;

                currNode = newMultilevelNode;
                randomNumber = this.getRandomInteger(1, 10);
            }

            this.head = currNode;
            return;
        }

        else if (value < currNode.data) {
            let mostRecentlyAddedMultilevelNode = null;

            while (currNode !== null) {
                const newMultilevelNode = new MultiLevelNode(value);
                currNode.prev = newMultilevelNode;
                newMultilevelNode.next = currNode;

                if (mostRecentlyAddedMultilevelNode !== null) {
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

        let nodesOfEachLevel: MultiLevelNode[] = [];

        while (currNode !== null) {
            if (currNode.data == value) {
                return;
            }
            
            if (currNode.data < value) {
                if (currNode.next == null || currNode.next.data > value) {
                    nodesOfEachLevel.push(currNode);
                    currNode = currNode.below;
                }                  
                else {
                    currNode = currNode.next;
                }
            }
        }

        nodesOfEachLevel = nodesOfEachLevel.reverse();

        let newMultilevelNode = new MultiLevelNode(value);
        newMultilevelNode.prev = nodesOfEachLevel[0];
        newMultilevelNode.next = nodesOfEachLevel[0].next;
        nodesOfEachLevel[0].next = newMultilevelNode
        if (newMultilevelNode.next !== null) {
            newMultilevelNode.next.prev = newMultilevelNode;
        }

        let i = 1;
        let randomNumber = this.getRandomInteger(1, 10);
        let mostRecentlyAddedMultilevelNode = newMultilevelNode;
        let mostRecentlyAddedHeadNode = null;
        const value_stored_in_head = this.head!.data;

        while (randomNumber <= 5) {
            newMultilevelNode = new MultiLevelNode(value);

            if (i < nodesOfEachLevel.length) {
                newMultilevelNode.next = nodesOfEachLevel[i].next;
                newMultilevelNode.prev = nodesOfEachLevel[i];
                nodesOfEachLevel[i].next = newMultilevelNode;

                if (newMultilevelNode.next !== null) {
                    newMultilevelNode.next.prev = newMultilevelNode;
                }

                i++;
            }

            else {
                const newHeadNode = new MultiLevelNode(value_stored_in_head);
                newHeadNode.next = newMultilevelNode;
                newMultilevelNode.prev = newHeadNode;
                
                if (mostRecentlyAddedHeadNode == null) {
                    this.head!.above = newHeadNode;
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
            
            randomNumber = this.getRandomInteger(1, 10);
        }
        
        if (mostRecentlyAddedHeadNode !== null) {
            this.head = mostRecentlyAddedHeadNode;
        }
    }


    delete(value: number): void {
        let currNode = this.head;

        if (currNode == null || currNode.data > value) {
            return;
        }

        while (currNode !== null) {
            if (currNode.data == value) {
                if (currNode.prev !== null) {
                    currNode.prev.next = currNode.next;
                }
                if (currNode.next !== null) {
                    currNode.next.prev = currNode.prev;
                }

                currNode = currNode.below;
            }
            
            if (currNode!.next == null || currNode!.next.data > value) {
                currNode = currNode!.below;
            }
            else {
                currNode = currNode!.next;
            }
        }
    }


    private getRandomInteger(min:number, max:number) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
}