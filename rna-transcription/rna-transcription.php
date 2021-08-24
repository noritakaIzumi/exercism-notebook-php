<?php

const RNA_DICT = array(
    'A' => 'U',
    'T' => 'A',
    'G' => 'C',
    'C' => 'G',
);

function toRna(string $dna): string
{
    $rna = '';

    foreach (str_split($dna) as $nucleotide) {
        $rna .= RNA_DICT[$nucleotide];
    }

    return $rna;
}
