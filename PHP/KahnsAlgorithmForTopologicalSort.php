<?php


// to run this file, use this command: php PHP/KahnsAlgorithmForTopologicalSort.php
class KahnsAlgorithmForTopologicalSort {
    public function getATopologicalSortingOfGivenNodes(array $nodesAndTheirSetsOfDependencies) {
        $numNodes = count(array_keys($nodesAndTheirSetsOfDependencies));

        $queue = [];

        foreach($nodesAndTheirSetsOfDependencies as $node => $setOfDependencies) {
            if (count(array_keys($setOfDependencies)) == 0) {
                $queue[] = $node;
                unset($nodesAndTheirSetsOfDependencies[$node]);
            }
        }

        $topologicalSorting = []; 

        while (count($queue) > 0) {
            $currNode = array_pop($queue);
            $topologicalSorting[] = $currNode;

            foreach($nodesAndTheirSetsOfDependencies as $node => $setOfDependencies) {
                unset($setOfDependencies[$currNode]);

                if (count(array_keys($setOfDependencies)) == 0) {
                    $queue[] = $node;
                    unset($nodesAndTheirSetsOfDependencies[$node]);
                }
            }
        }

        if (count($topologicalSorting) == $numNodes) {
            return [
                'topologicalSorting' => $topologicalSorting,
                'allNodesWereCovered' => true
            ];
        }

        return [
            'topologicalSorting' => $topologicalSorting,
            'allNodesWereCovered' => false
        ];
    }
}