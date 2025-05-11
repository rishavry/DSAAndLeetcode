// to run this file, use this command: npx ts-node TypeScript/DisjointSet.ts
class DisjointSet {
    size!:number;
    
    parents!:number[];
    ranks!:number[];
    sizes!:number[];


    constructor(size: number) {
        this.size = size;
        this.parents = Array.from({ length: size }, (_, i) => i);
        this.ranks = Array.from({ length: size }, () => 0);
        this.sizes = Array.from({ length: size }, () => 1);
    }


    // returns the root-member of an element's set
    find(element: number): number {
        let root = this.parents[element];

        if (root == element) {
            return root;
        }

        root = this.find(root);
        return root;
    }


    // unites two elements based on the ranks of their respective sets
    unionByRank(x: number, y: number): void {
        const rootX = this.find(x);
        const rootY = this.find(y);

        if (rootX == rootY) {
            return;
        }

        const rankX = this.ranks[rootX];
        const rankY = this.ranks[rootY];

        if (rankX < rankY) {
            this.parents[rootX] = rootY;
            this.sizes[rootY] += this.sizes[rootX];
        }
        else if (rankY < rankX) {
            this.parents[rootY] = rootX;
            this.sizes[rootX] += this.sizes[rootY];
        }
        else {
            this.parents[rootX] = rootY;
            this.ranks[rootY]++;
            this.sizes[rootY] += this.sizes[rootX];
        }
    }


    // unites two elements based on the sizes of their respective sets
    unionBySize(x: number, y: number): void {
        const rootX = this.find(x);
        const rootY = this.find(y);

        if (rootX == rootY) {
            return;
        }

        const sizeX = this.ranks[rootX];
        const sizeY = this.ranks[rootY];

        const rankX = this.ranks[rootX];
        const rankY = this.ranks[rootY];

        if (sizeX < sizeY) {
            this.parents[rootX] = rootY;
            this.sizes[rootY] += this.sizes[rootX];

            if (rankX == rankY) {
                this.ranks[rootY]++;
            }
        }
        else if (sizeY < sizeX) {
            this.parents[rootY] = rootX;
            this.sizes[rootX] += this.sizes[rootY];

            if (rankX == rankY) {
                this.ranks[rootX]++;
            }
        }
        else {
            this.parents[rootX] = rootY;
            this.sizes[rootY] += this.sizes[rootX];

            if (rankX == rankY) {
                this.ranks[rootY]++;
            }
        }
    }
}
