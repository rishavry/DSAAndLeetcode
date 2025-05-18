<?php


// to run this file, use this command: php PHP/Dijkstra.php
class Dijkstra {
    public function getShortestPathAndDistanceBetweenTwoNodes(string $nodeA, string $nodeB, array $nodesAndTheirEdges): array {
        $nodesAndTheirShortestDistancesFromNodeA = [
            $nodeA => 0
        ];
        $nodesAndTheirShortestPathsFromNodeA = [
            $nodeA => []
        ];

        $edgesFromNodeA = $nodesAndTheirEdges[$nodeA];
        $edgeOptions = [];

        foreach ($edgesFromNodeA as $node => $distance) {
            $edgeOptions[] = [
                'from' => $nodeA,
                'to' => $node,
                'distance' => $distance
            ];
        }

        usort($edgeOptions, function($edge1, $edge2) {
            return $edge1['distance'] <=> $edge2['distance'];
        });

        while (count($edgeOptions) > 0) {
            $minimumCostEdge = array_pop($edgeOptions);

            $fromNode = $minimumCostEdge['from'];
            $toNode = $minimumCostEdge['to'];
            $distance = $minimumCostEdge['distance'];

            $nodesAndTheirShortestDistancesFromNodeA[$toNode] = $nodesAndTheirShortestDistancesFromNodeA[$fromNode] + $distance;
            $nodesAndTheirShortestPathsFromNodeA[$toNode] = array_merge(
                $nodesAndTheirShortestPathsFromNodeA[$fromNode],
                [$toNode]
            );

            if ($toNode == $nodeB) {
                return [
                    'shortestPath' => $nodesAndTheirShortestPathsFromNodeA[$toNode],
                    'shortestDistance' => $nodesAndTheirShortestDistancesFromNodeA[$toNode]
                ];
            }

            $edgesFromToNode = $nodesAndTheirEdges[$toNode];
            foreach ($edgesFromToNode as $node => $distance) {
                if (array_key_exists($node, $nodesAndTheirShortestDistancesFromNodeA)) {
                    continue;
                }

                $newEdgeOption = [
                    'from' => $toNode,
                    'to' => $node,
                    'distance' => $distance
                ];
                $newEdgeOptionHasBeenAdded = false;

                for ($i=0; $i<count($edgeOptions); $i++) {
                    if ($distance < $edgeOptions[$i]['distance']) {
                        array_splice($edgeOptions, $i, 0, $newEdgeOption);
                        $newEdgeOptionHasBeenAdded = true;
                        break;
                    }
                }

                if (!$newEdgeOptionHasBeenAdded) {
                    $edgeOptions[] = $newEdgeOption;
                }
            }
        }

        return [
            'shortestPath' => [],
            'shortestDistance' => -1
        ];
    }
}