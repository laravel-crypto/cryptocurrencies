<?php

/*
 * cryptocurrency data query!!
 */

namespace Cryptocurrency\Services;

/**
 * Implements some common HTML stripping functionality for various services.
 */
abstract class AbstractHTMLService
{
    public function stripHTML($html)
    {
        $html = preg_replace("#[\n\t]+#", '', $html);
        $html = preg_replace('#</tr>#', "</tr>\n", $html);
        $html = preg_replace('#<td[^>]+?>#', '<td>', $html);
        $html = preg_replace('#<tr[^>]+?>#', '<tr>', $html);
        $html = preg_replace('#<span[^>]+?>#', '', $html);
        $html = preg_replace('#</span>#', '', $html);
        $html = preg_replace('#</?(b|i|em|strong)>#', '', $html);
        $html = preg_replace('#>\\s*<#', '><', $html);

        return $html;
    }
}
