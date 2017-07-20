<?php

namespace VT\VTCoreBundle\Services\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Rafael Kassner <kassner@gmail.com>
 */
class YearFunction extends FunctionNode
{
    public $date;

    public function getSql(SqlWalker $sqlWalker)
    {
        return "YEAR(" . $sqlWalker->walkArithmeticPrimary($this->date) . ")";
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
