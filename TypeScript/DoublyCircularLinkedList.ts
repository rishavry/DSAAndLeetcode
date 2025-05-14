// to run this file, use this command: npx ts-node TypeScript/DoublyCircularLinkedList.ts
class DoublyNode {
    data!: any;

    prev!: DoublyNode | null;
    next!: DoublyNode | null;


    constructor(data: any) {
        this.data = data;
    }
}


class DoublyCircularLinkedList {
    head!: DoublyNode | null;
    tail!: DoublyNode | null;
    
    size!:number;


    getHead(): DoublyNode | null {
        return this.head;
    }


    getTail(): DoublyNode | null {
        return this.tail;
    }


    getSize(): number {
        return this.size;
    }


    addElementToStart(data: any): void {
       const new_head_node = new DoublyNode(data);

        if (this.size == 0) {
            this.head = new_head_node;
            this.tail = new_head_node;

            new_head_node.next = new_head_node;
            new_head_node.prev = new_head_node;
        }
        else {
            this.head!.prev = new_head_node;
            new_head_node.next = this.head;
            new_head_node.prev = this.tail;
            this.tail!.next = new_head_node;
            this.head = new_head_node;
        }

        this.size++;
    }


    deleteFirstElement(): void {
        if (this.size == 0) {
            return;
        }
        
        const new_head_node = this.head!.next;
        new_head_node!.prev = this.tail;
        this.tail!.next = new_head_node;
        this.head = new_head_node;

        this.size--;
    }


    addElementToEnd(data: any): void {
        const new_tail_node = new DoublyNode(data);

        if (this.size == 0){
            this.head = new_tail_node;
            this.tail = new_tail_node;

            new_tail_node.next = new_tail_node;
            new_tail_node.prev = new_tail_node;
        }
        else {
            this.tail!.next = new_tail_node;
            new_tail_node.prev = this.tail;
            new_tail_node.next = this.head;
            this.head!.prev = new_tail_node;
            this.tail = new_tail_node;
        }

        this.size++;
    }


    deleteLastElement(): void {
        if (this.size == 0) {
            return;
        }
        
        const new_tail_node = this.tail!.prev;
        new_tail_node!.next = this.head;
        this.head!.prev = new_tail_node;
        this.tail = new_tail_node;

        this.size--;
    }
}