<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

class Tournament
{
    /**
     * @var TournamentTeamScore[] $teams
     */
    private array $teams = array();

    public function __construct()
    {
    }

    /**
     * 試合結果を集計して表を出力する。
     *
     * @param string $scores
     *
     * @return string
     */
    public function tally(string $scores): string
    {
        $scores = trim($scores);
        if ($scores === '') {
            $scoreArray = array();
        } else {
            $scoreArray = explode("\n", $scores);
        }
        foreach ($scoreArray as $score) {
            $this->registerCompetition($score);
        }

        $teamsByScore = $this->groupTeamsByScore();
        ksort($teamsByScore);
        $teamDisplayOrder = array();
        while ($teamsByScore !== array()) {
            $teams = array_pop($teamsByScore);
            sort($teams);
            $teamDisplayOrder = array_merge($teamDisplayOrder, $teams);
        }

        $tableFields = array(
            new TournamentOutcomeTableField('Team', 30, 'left'),
            new TournamentOutcomeTableField('MP', 2, 'right'),
            new TournamentOutcomeTableField('W', 2, 'right'),
            new TournamentOutcomeTableField('D', 2, 'right'),
            new TournamentOutcomeTableField('L', 2, 'right'),
            new TournamentOutcomeTableField('P', 2, 'right'),
        );
        $tableData = array();
        foreach ($teamDisplayOrder as $teamName) {
            $tableData[] = array(
                'Team' => $teamName,
                'MP' => $this->teams[$teamName]->mp,
                'W' => $this->teams[$teamName]->w,
                'D' => $this->teams[$teamName]->d,
                'L' => $this->teams[$teamName]->l,
                'P' => $this->teams[$teamName]->p,
            );
        }

        return $this->getFmtTable($tableFields, $tableData);
    }

    private function registerCompetition(string $score)
    {
        $fields = explode(';', $score);
        $teamName1 = $fields[0];
        $teamName2 = $fields[1];
        $result = $fields[2];
        foreach (array($teamName1, $teamName2) as $teamName) {
            if (!array_key_exists($teamName, $this->teams)) {
                $this->teams[$teamName] = new TournamentTeamScore();
            }
        }
        if ($result === MatchResult::WIN) {
            $this->teams[$teamName1]->countWin();
            $this->teams[$teamName2]->countLoss();
        } elseif ($result === MatchResult::LOSS) {
            $this->teams[$teamName1]->countLoss();
            $this->teams[$teamName2]->countWin();
        } elseif ($result === MatchResult::DRAW) {
            $this->teams[$teamName1]->countDraw();
            $this->teams[$teamName2]->countDraw();
        }
    }

    private function groupTeamsByScore(): array
    {
        $result = array();
        foreach ($this->teams as $teamName => $tournamentTeamScore) {
            $point = $tournamentTeamScore->p;
            if (!array_key_exists($point, $result)) {
                $result[$point] = array();
            }
            $result[$point][] = $teamName;
        }

        return $result;
    }

    /**
     * @param TournamentOutcomeTableField[] $fields
     * @param array                         $data
     *
     * @return string
     */
    private function getFmtTable(array $fields, array $data): string
    {
        $rows = array();
        $fieldDelimiter = ' | ';
        // header
        $headerRow = array();
        foreach ($fields as $field) {
            if ($field->align === 'left') {
                $length = $field->length;
                $headerRow[] = sprintf("%-${length}s", $field->name);
            } elseif ($field->align === 'right') {
                $length = $field->length;
                $headerRow[] = sprintf("%' ${length}s", $field->name);
            }
        }
        $rows[] = implode($fieldDelimiter, $headerRow);
        // data
        foreach ($data as $item) {
            $itemRow = array();
            foreach ($fields as $field) {
                if ($field->align === 'left') {
                    $length = $field->length;
                    $itemRow[] = sprintf("%-${length}s", $item[$field->name]);
                } elseif ($field->align === 'right') {
                    $length = $field->length;
                    $itemRow[] = sprintf("%' ${length}s", $item[$field->name]);
                }
            }
            $rows[] = implode($fieldDelimiter, $itemRow);
        }

        return implode("\n", $rows);
    }
}

class TournamentTeamScore
{
    /**
     * @var int $mp - matches played.
     */
    public int $mp = 0;
    /**
     * @var int $w - matches won.
     */
    public int $w = 0;
    /**
     * @var int $d - matches drown (tied).
     */
    public int $d = 0;
    /**
     * @var int $l - matches lost.
     */
    public int $l = 0;
    /**
     * @var int $p - points.
     */
    public int $p = 0;

    public function countWin()
    {
        $this->mp++;
        $this->w++;
        $this->p += 3;
    }

    public function countLoss()
    {
        $this->mp++;
        $this->l++;
    }

    public function countDraw()
    {
        $this->mp++;
        $this->d++;
        $this->p += 1;
    }
}

class MatchResult
{
    public const WIN = 'win';
    public const LOSS = 'loss';
    public const DRAW = 'draw';
}

class TournamentOutcomeTableField
{
    /**
     * @var string $name - field name.
     */
    public string $name;
    /**
     * @var int $length - field length.
     */
    public int $length;
    /**
     * @var string $align - field align (left or right).
     */
    public string $align;

    /**
     * @param string $name
     * @param int    $length
     * @param string $align
     */
    public function __construct(string $name, int $length, string $align)
    {
        $this->name = $name;
        $this->length = $length;
        $this->align = $align;
    }
}
