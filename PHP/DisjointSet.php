<?php


// to run this file, use this command: php PHP/DisjointSet.php
class DisjointSet {
    public int $size;
    public array $parents;
    public array $ranks;
    public array $sizes;


    public function __construct(int $size) {
        $this->size = $size;
        $this->parents = [];
        $this->ranks = [];
        $this->sizes = [];

        for ($i = 0; $i < $size; $i++) {
            $this->parents[$i] = $i;
            $this->ranks[$i] = 0;
            $this->sizes[$i] = 1;
        }
    }
    

    // returns the root-member of an element's set
    public function find(int $element): int {
        $root = $this->parents[$element];

        if ($root === $element) {
            return $root;
        }

        $root = $this->find($root);
        return $root;
    }


    // unites two elements based on the ranks of their respective sets
    public function union_by_rank(int $x, int $y): void {
        $root_x = $this->find($x);
        $root_y = $this->find($y);

        if ($root_x === $root_y) {
            return;
        }

        $rank_x = $this->ranks[$root_x];
        $rank_y = $this->ranks[$root_y];

        if ($rank_x < $rank_y) {
            $this->parents[$root_x] = $root_y;
            $this->sizes[$root_y] += $this->sizes[$root_x];
        }
        else if ($rank_y < $rank_x) {
            $this->parents[$root_y] = $root_x;
            $this->sizes[$root_x] += $this->sizes[$root_y];
        }
        else {
            $this->parents[$root_x] = $root_y;
            $this->ranks[$root_y] += 1;
            $this->sizes[$root_y] += $this->sizes[$root_x];
        }
    }


    // unites two elements based on the sizes of their respective sets
    public function union_by_size(int $x, int $y): void {
        $root_x = $this->find($x);
        $root_y = $this->find($y);

        if ($root_x === $root_y) {
            return;
        }

        $size_x = $this->ranks[$root_x];
        $size_y = $this->ranks[$root_y];

        $rank_x = $this->ranks[$root_x];
        $rank_y = $this->ranks[$root_y];

        if ($size_x < $size_y) {
            $this->parents[$root_x] = $root_y;
            $this->sizes[$root_y] += $this->sizes[$root_x];

            if ($rank_x === $rank_y) {
                $this->ranks[$root_y] += 1;
            }
        }
        else if ($size_y < $size_x) {
            $this->parents[$root_y] = $root_x;
            $this->sizes[$root_x] += $this->sizes[$root_y];

            if ($rank_x === $rank_y) {
                $this->ranks[$root_x] += 1;
            }
        }
        else {
            $this->parents[$root_x] = $root_y;
            $this->sizes[$root_y] += $this->sizes[$root_x];

            if ($rank_x === $rank_y) {
                $this->ranks[$root_y] += 1;
            }
        }
    }
}
