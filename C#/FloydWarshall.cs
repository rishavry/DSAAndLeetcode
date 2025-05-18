using System;


// compile with: csc C#/FloydWarshall.cs
// then, run with: mono FloydWarshall.exe
class FloydWarshall
{
    public object[][] GetShortestPathOfAllPairsOfNodesOfGraph(object[][] edgeDistanceMatrix)
    {
        int numNodes = edgeDistanceMatrix.Length;

        for (int i=0; i<numNodes; i++)
        {
            object[][] edgeDistanceMatrixCopy = edgeDistanceMatrix;
            
            for (int j=0; j<numNodes; j++)
            {
                if (i == j)
                {
                    continue;
                }

                for (int k=0; k<numNodes; k++)
                {
                    if (j == k)
                    {
                        continue;
                    }

                    if (edgeDistanceMatrix[j][i] is string || edgeDistanceMatrix[i][k] is string)
                    {
                        continue;
                    }

                    int potentialNewDistance = (int) edgeDistanceMatrix[j][i] + (int) edgeDistanceMatrix[i][k];

                    if (edgeDistanceMatrix[j][k] is string) {
                        edgeDistanceMatrix[j][k] = potentialNewDistance;
                    }
                    else {
                        edgeDistanceMatrix[j][k] = Math.Min((int) edgeDistanceMatrix[j][k], potentialNewDistance);
                    }
                }
            }
        }

        return edgeDistanceMatrix;
    }


    public static void Main(String[] args)
    {}
}