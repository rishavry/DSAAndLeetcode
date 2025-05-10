// compile with: csc C#/DisjointSet.cs
// then, run with: mono C#/DisjointSet.exe
using System;


class DisjointSet
{
    int size;
    int[] parents;
    int[] ranks;
    int[] sizes;


    public DisjointSet(int size)
    {
        this.size = size;
        this.parents = new int[size];
        this.ranks = new int[size];
        this.sizes = new int[size];

        for (int i = 0; i < size; i++)
        {
            this.parents[i] = i;
            this.ranks[i] = 0;
            this.sizes[i] = 1;
        }
    }


    // returns the root-member of an element's set
    public int Find(int element)
    {
        int root = this.parents[element];

        if (root == element)
        {
            return root;
        }

        root = Find(root);
        return root;
    }


    // unites two elements based on the ranks of their respective sets
    public void UnionByRank(int x, int y)
    {
        int rootX = Find(x);
        int rootY = Find(y);

        if (rootX == rootY)
        {
            return;
        }

        int rankX = this.ranks[rootX];
        int rankY = this.ranks[rootY];

        if (rankX < rankY)
        {
            this.parents[rootX] = rootY;
            this.sizes[rootY] += this.sizes[rootX];
        }
        else if (rankY < rankX)
        {
            this.parents[rootY] = rootX;
            this.sizes[rootX] += this.sizes[rootY];
        }
        else
        {
            this.parents[rootX] = rootY;
            this.ranks[rootY] += 1;
            this.sizes[rootY] += this.sizes[rootX];
        }
    }


    // unites two elements based on the sizes of their respective sets
    public void UnionBySize(int x, int y)
    {
        int rootX = Find(x);
        int rootY = Find(y);

        if (rootX == rootY)
        {
            return;
        }

        int sizeX = this.ranks[rootX];
        int sizeY = this.ranks[rootY];

        int rankX = this.ranks[rootX];
        int rankY = this.ranks[rootY];

        if (sizeX < sizeY)
        {
            this.parents[rootX] = rootY;
            this.sizes[rootY] += this.sizes[rootX];

            if (rankX == rankY)
            {
                this.ranks[rootY] += 1;
            }
        }
        else if (sizeY < sizeX)
        {
            this.parents[rootY] = rootX;
            this.sizes[rootX] += this.sizes[rootY];

            if (rankX == rankY)
            {
                this.ranks[rootX] += 1;
            }
        }
        else
        {
            this.parents[rootX] = rootY;
            this.sizes[rootY] += this.sizes[rootX];

            if (rankX == rankY)
            {
                this.ranks[rootY] += 1;
            }
        }
    }


    public static void Main(String[] args) {}
}