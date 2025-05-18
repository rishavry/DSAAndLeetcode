from typing import List, Set


# to run, use: python3 Python/Kruskal.py
class Kruskal:
    def get_minimum_spanning_tree_of_graph(set_of_nodes: Set[str], list_of_edges: List[List[str|int]]):
        num_nodes = len(set_of_nodes)
        set_of_visited_nodes = set()
        edges_of_minimum_spanning_tree = []
        list_of_edges = sorted(list_of_edges, key=lambda x: x[2])
        min_cost = 0

        while len(list_of_edges) > 0:
            min_cost_edge = list_of_edges.pop(0)
            if min_cost_edge[0] in set_of_visited_nodes and min_cost_edge[1] in set_of_visited_nodes:
                continue

            set_of_visited_nodes.add(min_cost_edge[0])
            set_of_visited_nodes.add(min_cost_edge[1])

            min_cost+= min_cost_edge[2]

            edges_of_minimum_spanning_tree.add(min_cost_edge)

            if len(set_of_visited_nodes) == num_nodes:
                return {
                    'edges': edges_of_minimum_spanning_tree,
                    'minCost': min_cost
                }

        return {
            'edges': [],
            'minCost': min_cost
        }