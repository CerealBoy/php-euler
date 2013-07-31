#!/usr/bin/env php
<?php
/**
 * A solution for Problem 96.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$input = explode("\n", file_get_contents(__DIR__ . '/0096.input'));
$puzzles = array();
$tmp = '';

foreach ($input as $counter => $line) {
    if ($counter % 10 === 0) {
        continue;
    }

    $tmp .= $line;
    if (($counter + 1) % 10 === 0) {
        $puzzles[] = $tmp;
        $tmp = '';
    }
}

$total = 0;
foreach ($puzzles as $puzzle) {
    $sudoku = new Sudoku($puzzle);

    try {
        $sudoku->solve();

        if (!$sudoku->isValid()) {
            throw new \RuntimeException('Invalid solution');
        }

        $total += $sudoku->getFirstTriple();
    } catch (Exception $e) {
        die("Failed: [{$e->getMessage()}]\n");
    }
}

echo "The grand total is [{$total}]\n\n";

/**
 * A Sudoku solver class.
 *
 * This class takes a sequential string containing a Sudoku puzzle ready to be solved.
 *  This string can be concatenated directly from the input from Euler. The splitting,
 *  initialisation, and processing, is all contained within this class.
 */
class Sudoku
{
    /**
     * The constructor takes the workable sudoku puzzle.
     *
     * @param string $sudoku
     *  The Sudoku in the form of a single string of ints.
     */
    public function __construct($sudoku)
    {
        if (strlen($sudoku) !== 81) {
            throw new \InvalidArgumentException('Invalid board');
        }

        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                $this->sudoku[$y][$x] = (int)$sudoku[($y * 9) + $x];
            }
        }
    }

    /**
     * Return the first triple for adding to the total.
     *
     * @return int
     */
    public function getFirstTriple()
    {
        $total = (((int)$this->sudoku[0][0] * 100) +
            ((int)$this->sudoku[0][1] * 10) +
            ((int)$this->sudoku[0][2]));

        return (int)$total;
    }

    /**
     * Begin the solving process.
     *
     * @return bool
     */
    public function solve()
    {
        $this->usedInBox = range(0, 2);
        foreach ($this->usedInBox as $indexA) {
            $this->usedInBox[$indexA] = range(0, 2);

            foreach ($this->usedInBox[$indexA] as $indexB => $bogus) {
                $this->usedInBox[$indexA][$indexB] = range(0, 8);

                foreach ($this->usedInBox[$indexA][$indexB] as $indexC => $c) {
                    $this->usedInBox[$indexA][$indexB][$indexC] = false;
                }
            }
        }

        $this->usedInRow = range(0, 8);
        foreach ($this->usedInRow as $indexA) {
            $this->usedInRow[$indexA] = range(0, 8);

            foreach ($this->usedInRow[$indexA] as $indexB) {
                $this->usedInRow[$indexA][$indexB] = false;
            }
        }

        $this->usedInColumn = range(0, 8);
        foreach ($this->usedInColumn as $indexA) {
            $this->usedInColumn[$indexA] = range(0, 8);

            foreach ($this->usedInColumn[$indexA] as $indexB) {
                $this->usedInColumn[$indexA][$indexB] = false;
            }
        }

        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                if ($this->sudoku[$y][$x] === 0) {
                    continue;
                }

                $value = $this->sudoku[$y][$x] - 1;

                $this->usedInRow[$y][$value] = true;
                $this->usedInColumn[$x][$value] = true;
                $this->usedInBox[floor($y / 3)][floor($x / 3)][$value] = true;
            }
        }

        return $this->runSolve(0);
    }

    /**
     * Determine if the Puzzle is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        $usedInRow = range(0, 8);
        $usedInColumn = range(0, 8);
        $usedInBox = range(0, 2);

        foreach ($usedInRow as $index) {
            $usedInRow[$index] = range(0, 8);
            foreach ($usedInRow[$index] as $i) {
                $usedInRow[$index][$i] = false;
            }
        }

        foreach ($usedInColumn as $index) {
            $usedInColumn[$index] = range(0, 8);
            foreach ($usedInColumn[$index] as $i) {
                $usedInColumn[$index][$i] = false;
            }
        }

        foreach ($usedInBox as $indexA) {
            $usedInBox[$indexA] = range(0, 2);
            foreach ($usedInBox[$indexA] as $indexB) {
                $usedInBox[$indexA][$indexB] = range(0, 8);
                foreach ($usedInBox[$indexA][$indexB] as $i) {
                    $usedInBox[$indexA][$indexB][$i] = false;
                }
            }
        }

        for ($y = 0; $y < 9; $y++) {
            for ($x = 0; $x < 9; $x++) {
                if ($this->sudoku[$y][$x] === 0) {
                    continue;
                }

                $value = $this->sudoku[$y][$x] - 1;
                if ($usedInRow[$y][$value] || $usedInColumn[$x][$value] || $usedInBox[floor($y / 3)][floor($x / 3)][$value]) {
                    return false;
                }

                $usedInRow[$y][$value] = true;
                $usedInColumn[$x][$value] = true;
                $usedInBox[floor($y / 3)][floor($x / 3)][$value] = true;
            }
        }

        return true;
    }

    /**
     * Dump the Sudoku out.
     */
    public function dump()
    {
        foreach ($this->sudoku as $y => $row) {
            foreach ($row as $x => $value) {
                echo "{$value} ";
            }

            echo "\n";
        }

        echo "\n";
    }

    /**
     * Handle logical solving.
     *
     * @param int $index
     *  The index to solve.
     * @return bool
     */
    private function runSolve($index)
    {
        for ($index; $index < 81 && $this->sudoku[$index / 9][$index % 9] !== 0; $index++) {
            //
        }

        if ($index === 81) {
            return true;
        }

        $x = $index % 9;
        $y = floor($index / 9);

        for ($i = 0; $i < 9; $i++) {
            if (!$this->usedInRow[$y][$i] && !$this->usedInColumn[$x][$i] && !$this->usedInBox[floor($y / 3)][floor($x / 3)][$i]) {
                $this->sudoku[$y][$x] = $i + 1;

                $this->usedInRow[$y][$i] = true;
                $this->usedInColumn[$x][$i] = true;
                $this->usedInBox[floor($y / 3)][floor($x / 3)][$i] = true;

                if ($this->runSolve($index + 1)) {
                    return true;
                }

                $this->usedInRow[$y][$i] = false;
                $this->usedInColumn[$x][$i] = false;
                $this->usedInBox[floor($y / 3)][floor($x / 3)][$i] = false;
            }
        }

        $this->sudoku[$y][$x] = 0;
        return false;
    }

    /**
     * Store the unsolved sudoku puzzle.
     *
     * @var array
     */
    private $sudoku = array();

    /**
     * Keep track of what's used across the rows.
     *
     * @var array
     */
    private $usedInRow = array();

    /**
     * Keep track of what's used in columns.
     *
     * @var array
     */
    private $usedInColumn = array();

    /**
     * Keep track of each 3x3 box.
     *
     * @var array
     */
    private $usedInBox = array();
}

