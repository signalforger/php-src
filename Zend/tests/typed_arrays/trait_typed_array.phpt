--TEST--
Trait: typed array in trait method
--FILE--
<?php
declare(strict_arrays=1);

trait Taggable {
    private array<string> $tags = [];

    public function addTag(string $tag): void {
        $this->tags[] = $tag;
    }

    public function getTags(): array<string> {
        return $this->tags;
    }
}

class Article {
    use Taggable;

    public function __construct(public string $title) {}
}

$article = new Article("PHP Typed Arrays");
$article->addTag("php");
$article->addTag("types");
$article->addTag("arrays");

echo "Title: {$article->title}\n";
echo "Tags: " . implode(", ", $article->getTags()) . "\n";

?>
--EXPECT--
Title: PHP Typed Arrays
Tags: php, types, arrays
