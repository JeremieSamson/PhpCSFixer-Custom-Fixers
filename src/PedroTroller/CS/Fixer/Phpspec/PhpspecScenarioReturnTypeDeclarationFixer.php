<?php

namespace PedroTroller\CS\Fixer\Phpspec;

use PedroTroller\CS\Fixer\AbstractFixer;
use PedroTroller\CS\Fixer\PhpspecFixer;
use PedroTroller\CS\Fixer\Priority;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

final class PhpspecScenarioReturnTypeDeclarationFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     */
    public function isCandidate(Tokens $tokens)
    {
        return \PHP_VERSION_ID >= 70100 && $this->extendsClass($tokens, 'PhpSpec\ObjectBehavior');
    }

    /**
     * {@inheritdoc}
     */
    public function getDocumentation()
    {
        return 'PHPSpec spec functions MUST NOT have a return type declaration.';
    }

    /**
     * {@inheritdoc}
     */
    public function isDeprecated()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeprecationReplacement()
    {
        return (new PhpspecFixer())->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getSampleCode()
    {
        return <<<'SPEC'
<?php

namespace spec\Project\TheNamespace;

use PhpSpec\ObjectBehavior;

class TheSpec extends ObjectBehavior
{
    function let($file) {
        return;
    }

    function letGo($file): void {
        return;
    }

    function it_is_a_spec($file): void {
        return;
    }

    function itIsNotASpec($file): void {
        return;
    }

    public function its_other_function($file): array {
        return [];
    }
}
SPEC;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return Priority::after(VoidReturnFixer::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function applyFix(SplFileInfo $file, Tokens $tokens)
    {
        foreach ($tokens as $index => $token) {
            if (T_FUNCTION !== $token->getId()) {
                continue;
            }

            $functionNameIndex = $tokens->getNextMeaningfulToken($index);

            if (null === $functionNameIndex) {
                continue;
            }

            $functionName = $tokens[$functionNameIndex];

            if (T_STRING !== $functionName->getId()) {
                continue;
            }

            if (0 === preg_match('/^(let(Go)?|it_.+|its_.+)$/', $functionName->getContent())) {
                continue;
            }

            $openBraceIndex    = $tokens->getNextTokenOfKind($index, ['(']);
            $closeBraceIndex   = $this->analyze($tokens)->getClosingParenthesis($openBraceIndex);
            $openCurlyBracket  = $tokens->getNextTokenOfKind($index, ['{']);
            $returnDeclaration = $this->analyze($tokens)->getReturnedType($index);

            if (null === $returnDeclaration || null === $closeBraceIndex || null === $openCurlyBracket) {
                continue;
            }

            if ($closeBraceIndex >= $openCurlyBracket - 1) {
                continue;
            }

            $tokens->clearRange($closeBraceIndex + 1, $openCurlyBracket - 1);
            $tokens->insertAt($openCurlyBracket, new Token(' '));
        }
    }
}
