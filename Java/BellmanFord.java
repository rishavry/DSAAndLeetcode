package Java;

import java.util.ArrayList;
import java.util.HashMap;


// to compile: javac Java/BellmanFord.java
// to run: java Java/BellmanFord
public class BellmanFord {
    public HashMap<String, Object> getShortestPathsAndDistancesFromOneNodeToAllOthers(String[] listOfNodes, Object[][]
    listOfEdges, String sourceNode) {
        HashMap<String, Object> nodesAndTheirShortestDistancesFromSourceNode = new HashMap<String, Object>();
        HashMap<String, ArrayList<String>> nodesAndTheirShortestPathsFromSourceNode =
        new HashMap<String, ArrayList<String>>();

        for (String node : listOfNodes) {
            if (node.equals(sourceNode)) {
                nodesAndTheirShortestDistancesFromSourceNode.put(node, 0);
               
                nodesAndTheirShortestPathsFromSourceNode.put(node, new ArrayList<String>());
                nodesAndTheirShortestPathsFromSourceNode.get(node).add(sourceNode);
            }
            else {
                nodesAndTheirShortestDistancesFromSourceNode.put(node, "infinity");
                
                nodesAndTheirShortestPathsFromSourceNode.put(node, null);
            }
        }

        int numNodes = listOfNodes.length;

        HashMap<String, Object> output = new HashMap<String, Object>();

        for (int i=0; i<numNodes; i++) {
            for (Object[] edge : listOfEdges) {
                String nodeA = (String) edge[0];
                String nodeB = (String) edge[1];
                int edgeWeight = (int) edge[2];

                Object shortestDistanceCalculatedSoFarForNodeA = nodesAndTheirShortestDistancesFromSourceNode.get(nodeA);

                if (shortestDistanceCalculatedSoFarForNodeA.equals("infinity")) {
                    continue;
                }

                Object shortestDistanceCalculatedSoFarForNodeB = nodesAndTheirShortestDistancesFromSourceNode.get(nodeB);

                int potentialNewShortestDistanceForToNode = (int) shortestDistanceCalculatedSoFarForNodeA + edgeWeight;

                if (shortestDistanceCalculatedSoFarForNodeB.equals("infinity") || potentialNewShortestDistanceForToNode <
                (int) shortestDistanceCalculatedSoFarForNodeB) {
                    nodesAndTheirShortestDistancesFromSourceNode.put(nodeB, potentialNewShortestDistanceForToNode);
                    
                    nodesAndTheirShortestPathsFromSourceNode.put(nodeB, nodesAndTheirShortestPathsFromSourceNode.get(nodeA));
                    nodesAndTheirShortestPathsFromSourceNode.get(nodeB).add(nodeB);

                    if (i == numNodes-1) {
                        output.put("negativeCycleDetected", true);
                        return output;
                    }
                }

            }
        }

        output.put("nodesAndTheirShortestDistancesFromSourceNode", nodesAndTheirShortestDistancesFromSourceNode);
        output.put("nodesAndTheirShortestPathsFromSourceNode", nodesAndTheirShortestPathsFromSourceNode);
        
        return output;
    }

    
    public static void main(String[] args) {}
}
