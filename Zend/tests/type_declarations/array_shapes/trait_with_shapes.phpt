--TEST--
Traits with array shape types
--XLEAK--
--FILE--
<?php

// Test 1: Basic trait with array shape return type
trait Timestampable {
    public function getTimestamps(): array{created_at: string, updated_at: string} {
        return [
            'created_at' => '2024-01-01 00:00:00',
            'updated_at' => '2024-06-15 12:30:00'
        ];
    }
}

class Article {
    use Timestampable;

    public function __construct(public string $title) {}
}

$article = new Article('Hello World');
$times = $article->getTimestamps();
echo "Article created: {$times['created_at']}\n";

// Test 2: Trait with typed array parameter
trait Taggable {
    private array $tags = [];

    public function setTags(array<string> $tags): void {
        $this->tags = $tags;
    }

    public function getTags(): array<string> {
        return $this->tags;
    }
}

class Post {
    use Taggable;

    public function __construct(public string $content) {}
}

$post = new Post('My post content');
$post->setTags(['php', 'rfc', 'array-shapes']);
echo "Tags: " . implode(', ', $post->getTags()) . "\n";

// Test 3: Multiple traits with shapes
trait HasMetadata {
    public function getMetadata(): array{version: int, author: string} {
        return ['version' => 1, 'author' => 'System'];
    }
}

trait HasStatus {
    public function getStatus(): array{active: bool, status: string} {
        return ['active' => true, 'status' => 'published'];
    }
}

class Document {
    use HasMetadata, HasStatus;

    public function getFullInfo(): array{version: int, author: string, active: bool, status: string} {
        return [...$this->getMetadata(), ...$this->getStatus()];
    }
}

$doc = new Document();
$info = $doc->getFullInfo();
echo "Doc v{$info['version']} by {$info['author']}: {$info['status']}\n";

// Test 4: Trait method with array shape in class implementing interface
interface Configurable {
    public function getConfig(): array{enabled: bool};
}

trait DefaultConfig {
    public function getConfig(): array{enabled: bool, timeout: int} {
        return ['enabled' => true, 'timeout' => 30];
    }
}

class Service implements Configurable {
    use DefaultConfig;
}

$service = new Service();
$config = $service->getConfig();
echo "Service enabled: " . ($config['enabled'] ? 'yes' : 'no') . ", timeout: {$config['timeout']}\n";

echo "Done\n";
?>
--EXPECT--
Article created: 2024-01-01 00:00:00
Tags: php, rfc, array-shapes
Doc v1 by System: published
Service enabled: yes, timeout: 30
Done
