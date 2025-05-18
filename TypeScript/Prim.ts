// to run, use: npx ts-node TypeScript/Prim.ts
class Prim {
    getMinimumSpanningTreeOfGraph(setOfNodes: Set<string>, nodesAndTheirEdges: Record<string, any[]>) {
        const numNodes = setOfNodes.size;
        let minimumCostEdge:any[] = [];

        for(let fromNode of Object.keys(nodesAndTheirEdges)) {
            for(let edge of Object.keys(nodesAndTheirEdges[fromNode])) {
                const toNode = edge[0];
                const edgeCost = edge[1];

                if (minimumCostEdge.length == 0 || edgeCost < minimumCostEdge[2]) {
                    minimumCostEdge = [fromNode, toNode, edgeCost];
                }
            }
        }

        const edgeOptions:any[] = [];
        for(let edge of Object.keys(nodesAndTheirEdges[minimumCostEdge[0]])) {
            edgeOptions.push([minimumCostEdge[0], edge[0], edge[1]]);
        }

        for(let edge of Object.keys(nodesAndTheirEdges[minimumCostEdge[1]])) {
            edgeOptions.push([minimumCostEdge[1], edge[0], edge[1]]);
        }

        edgeOptions.sort((edge1, edge2) => edge1[2] - edge2[2]);
        
        const setOfVisitedNodes = new Set();

        const edgesOfMinimumSpanningTree:any[] = [];

        let minCost:number = 0;

        while (edgeOptions.length > 0) {
            const minimumCostEdgeOption = edgeOptions.shift();

            const destinationNode = minimumCostEdgeOption[1];

            if (destinationNode in setOfVisitedNodes) {
                continue;
            }

            setOfVisitedNodes.add(destinationNode);

            edgesOfMinimumSpanningTree.push(minimumCostEdgeOption);

            minCost+= minimumCostEdgeOption[2];

            if (setOfVisitedNodes.size == numNodes) {
                return {
                    edges: edgesOfMinimumSpanningTree,
                    minCost: minCost
                };
            }
            
            for(let edge of Object.keys(nodesAndTheirEdges[destinationNode])) {
                const newEdgeOption = [destinationNode, edge[0], edge[1]];
                let newEdgeOptionHasBeenInserted = false;

                for (let i=0; i<edgeOptions.length; i++) {
                    if (newEdgeOption[2] < edgeOptions[i][2]) {
                        edgeOptions.splice(i, 0, newEdgeOption);
                        newEdgeOptionHasBeenInserted = true;
                        break;
                    }
                }

                if (!newEdgeOptionHasBeenInserted) {
                    edgeOptions.push(newEdgeOption);
                }
            }
        }

        return {
            edges: [],
            minCost: minCost
        };
    }
}